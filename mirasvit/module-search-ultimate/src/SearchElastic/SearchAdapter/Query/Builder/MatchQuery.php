<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-search-ultimate
 * @version   2.0.97
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\SearchElastic\SearchAdapter\Query\Builder;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\AttributeProvider;
use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\FieldProvider\FieldType\ResolverInterface as TypeResolver;
use Magento\Elasticsearch\Model\Adapter\FieldMapperInterface;
use Magento\Elasticsearch\Model\Config;
use Magento\Elasticsearch\SearchAdapter\Query\ValueTransformerPool;
use Magento\Framework\Search\Request\QueryInterface as RequestQueryInterface;
use Mirasvit\Search\Model\ConfigProvider;
use Mirasvit\Search\Service\QueryService;

class MatchQuery extends MatchCompatibility
{
    private $queryService;

    private $fieldMapper;

    private $attributeProvider;

    private $attributeRepository;

    private $config;

    private $searchTerms = [];

    public function __construct(
        QueryService                 $queryService,
        FieldMapperInterface         $fieldMapper,
        AttributeProvider            $attributeProvider,
        TypeResolver                 $fieldTypeResolver,
        ValueTransformerPool         $valueTransformerPool,
        AttributeRepositoryInterface $attributeRepository,
        Config                       $config
    ) {
        $this->queryService        = $queryService;
        $this->fieldMapper         = $fieldMapper;
        $this->attributeProvider   = $attributeProvider;
        $this->attributeRepository = $attributeRepository;
        $this->config              = $config;

        parent::__construct($fieldMapper, $attributeProvider, $fieldTypeResolver, $valueTransformerPool, $config);
    }

    /**
     * @param string $conditionType
     */
    public function build(array $selectQuery, RequestQueryInterface $requestQuery, $conditionType): array
    {
        $this->searchTerms = [];
        $queryValue        = $requestQuery->getValue();
        $searchQuery       = $this->queryService->build($queryValue);
        $queryValue        = $searchQuery['query'];
        $fields            = [];

        foreach ($requestQuery->getMatches() as $match) {
            $attribute = false;
            try {
                $attribute = $this->attributeRepository->get(Product::ENTITY, $match['field']);
            } catch (\Exception $e) {
            }

            if ($attribute && in_array($attribute->getFrontendInput(), ['price', 'weight', 'date', 'datetime'])) {
                continue;
            }

            $boost = (int)($match['boost'] ?? 1);

            $resolvedField = $this->fieldMapper->getFieldName(
                $match['field'],
                ['type' => FieldMapperInterface::TYPE_QUERY]
            );

            if (in_array($resolvedField, ['links_purchased_separately'])) {
                continue;
            }

            if ($resolvedField === '_search') {
                $resolvedField = '_misc';
            }

            $fields[$resolvedField] = $boost > 1 ? pow(2, $boost) + 128 : $boost;
        }

        if (!isset($selectQuery['bool'])) {
            $selectQuery['bool'] = ['must' => []];
        }

        if (!$this->isKeyExists($selectQuery['bool']['must'], 'query_string')) {
            $preparedFields = [];

            $compiledQuery = $this->compileQuery($searchQuery['built']);

            $wildcardExceptions = $searchQuery['wildcardExceptions'];

            if (empty($wildcardExceptions)) {
                $processedQuery = $queryValue;
            } else {
                $processedQuery = $this->escape(preg_replace('~\b(' . implode('|', $wildcardExceptions) . ')\b~', " $1 ", $queryValue));
            }

            $terms = preg_split('~\s~', $processedQuery);

            if (isset($fields['name'])) {
                $fields['name.keyword'] = $fields['name'];
            }

            if (isset($fields['sku'])) {
                $fields['sku.keyword'] = $fields['sku'];
            }

            foreach ($fields as $field => $boost) {
                $preparedFields[] = $field;

                $selectQuery['bool']['should'][]['terms'] = [
                    $field  => $terms,
                    'boost' => $boost,
                ];

                if ($boost > 500) {
                    $selectQuery['bool']['should'][]['match_phrase'] = [
                        $field => [
                            'query' => $processedQuery,
                            'boost' => (string)($boost + 100),
                        ],
                    ];

                    $selectQuery['bool']['should'][]['wildcard'][$field] = [
                        'value' => $processedQuery . '*',
                        'boost' => (string)($boost + 50),
                    ];

                    $selectQuery['bool']['should'][]['wildcard'][$field] = [
                        'value' => '*' . $processedQuery,
                        'boost' => (string)($boost + 50),
                    ];

                    $selectQuery['bool']['should'][]['wildcard'][$field] = [
                        'value' => '*' . $processedQuery . '*',
                        'boost' => (string)($boost + 10),
                    ];
                }

                foreach ($this->searchTerms as $term => $boostMultiplier) {
                    $term = (string)$term;

                    if (strlen($term) < 3) {
                        $selectQuery['bool']['should'][]['wildcard'][$field] = [
                            'value' => $term,
                            'boost' => (string)$boost * 0.75 * (float)$boostMultiplier,
                        ];
                    } else {
                        $selectQuery['bool']['should'][]['wildcard'][$field] = [
                            'value' => $term,
                            'boost' => (string)$boost * (float)$boostMultiplier,
                        ];
                    }
                }

                if (count($selectQuery['bool']['should']) > 1000) {
                    break;
                }
            }

            unset($processedQuery);

            $selectQuery['bool']['must'][]['query_string'] = [
                'query'            => $compiledQuery,
                'fields'           => $preparedFields,
                'default_operator' => strtoupper($searchQuery['matchMode']),
            ];
        }

        return $selectQuery;
    }

    private function isKeyExists(array $array, string $keySearch): bool
    {
        if (array_key_exists($keySearch, $array)) {
            return true;
        } else {
            foreach ($array as $key => $item) {
                if (is_array($item) && $this->isKeyExists($item, $keySearch)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function compileQuery(array $query): string
    {
        $compiled = [];
        foreach ($query as $directive => $value) {
            switch ($directive) {
                case '$like':
                    $compiled[] = '(' . $this->compileQuery($value) . ')';
                    break;
                case '$and':
                    $and = [];
                    foreach ($value as $item) {
                        $and[] = $this->compileQuery($item);
                    }
                    $compiled[] = '(' . implode(' AND ', $and) . ')';
                    break;

                case '$or':
                    $or = [];
                    foreach ($value as $item) {
                        $or[] = $this->compileQuery($item);
                    }
                    $compiled[] = '(' . implode(' OR ', $or) . ')';
                    break;

                case '$term':
                    $phrase = $this->escape($value['$phrase']);
                    switch ($value['$wildcard']) {
                        case ConfigProvider::WILDCARD_INFIX:
                            $compiled[]                     = "$phrase OR *$phrase*";
                            $this->searchTerms[$phrase]     = 1;
                            $this->searchTerms["*$phrase*"] = 0.3;
                            break;
                        case ConfigProvider::WILDCARD_PREFIX:
                            $compiled[]                    = "$phrase OR *$phrase";
                            $this->searchTerms[$phrase]    = 1;
                            $this->searchTerms["*$phrase"] = 0.5;
                            break;
                        case ConfigProvider::WILDCARD_SUFFIX:
                            $compiled[]                    = "$phrase OR $phrase*";
                            $this->searchTerms[$phrase]    = 1;
                            $this->searchTerms["$phrase*"] = 0.5;
                            break;
                        case ConfigProvider::WILDCARD_DISABLED:
                            if (strpos($phrase, ' ') !== false) {
                                $compiled[] = "($phrase)";
                            } else {
                                $compiled[] = $phrase;
                            }
                            $this->searchTerms[$phrase] = 1;
                            break;
                    }
                    break;
            }
        }

        return implode(' OR ', $compiled);
    }

    private function escape(string $value): string
    {
        $pattern = '/(\+|-|\/|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
        $replace = '\\\$1';

        return preg_replace($pattern, $replace, $value);
    }
}
