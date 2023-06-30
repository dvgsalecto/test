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
 * @package   mirasvit/module-dynamic-category
 * @version   1.2.22
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */



declare(strict_types=1);

namespace Mirasvit\DynamicCategory\Model\DynamicCategory\Condition;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Rule\Model\Condition\Context;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Service\AttributeService;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Combine extends \Magento\Rule\Model\Condition\Combine
{
    /**
     * Cache of loaded products
     * @var array
     */
    private static $products = [];

    private $limit = 5000;

    private $attributeService;

    private $collectionFactory;

    private $productCondition;

    private $productRepository;

    private $registry;

    private $resource;

    private $smartConditions = [];

    private $sourceCondition;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        AttributeService $attributeService,
        CollectionFactory $collectionFactory,
        ProductCondition $productCondition,
        ProductRepository $productRepository,
        SmartCondition\IsNewCondition $isNewCondition,
        SmartCondition\IsSalableCondition $isSalableCondition,
        SmartCondition\OnSaleCondition $onSaleCondition,
        SmartCondition\RatingCondition $ratingCondition,
        SmartCondition\ReviewCondition $reviewCondition,
        SmartCondition\CreatedCondition $createdCondition,
        Msi\SourceCondition $sourceCondition,
        Registry $registry,
        ResourceConnection $resource,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->attributeService  = $attributeService;
        $this->collectionFactory = $collectionFactory;
        $this->productCondition  = $productCondition;
        $this->productRepository = $productRepository;
        $this->sourceCondition   = $sourceCondition;
        $this->smartConditions   = [
            $isNewCondition,
            $isSalableCondition,
            $onSaleCondition,
            $ratingCondition,
            $reviewCondition,
            $createdCondition,
        ];

        $this->registry = $registry;
        $this->resource = $resource;

        $this->setData('type', self::class);
    }

    public function getNewChildSelectOptions(): array
    {
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, [
            [
                'value' => self::class,
                'label' => (string)__('Conditions Combination'),
            ],
        ]);

        $pool = [
            'Product Attributes' => $this->productCondition,
        ];

        foreach ($pool as $label => $conditionModel) {
            $conditionAttributes = $conditionModel->loadAttributeOptions()->getData('attribute_option');

            $attributes = [];
            foreach ($conditionAttributes as $code => $attributeLabel) {
                $attributes[] = [
                    'value' => get_class($conditionModel) . '|' . $code,
                    'label' => (string)$attributeLabel,
                ];
            }

            $conditions = array_merge_recursive($conditions, [
                [
                    'label' => (string)__($label),
                    'value' => $attributes,
                ],
            ]);
        }


        $smartValues = [];
        foreach ($this->smartConditions as $condition) {
            $smartValues[] = [
                'label' => $condition->getAttributeElementHtml(),
                'value' => get_class($condition),
            ];
        }

        $conditions[] = [
            'label' => (string)__('Smart Attributes'),
            'value' => $smartValues,
        ];


        $conditions[] = [
            'label' => (string)__('MSI'),
            'value' => [
                [
                    'label' => $this->sourceCondition->getAttributeElementHtml(),
                    'value' => get_class($this->sourceCondition),
                ],
            ],
        ];

        return $conditions;
    }

    public function collectValidatedAttributes(Collection $collection): Combine
    {
        foreach ($this->getConditions() as $condition) {
            $condition->collectValidatedAttributes($collection);
        }

        return $this;
    }

    public function applyConditions(Collection $productCollection): Combine
    {
        $sqlCondition = $this->getSqlCondition($productCollection);

        if ($sqlCondition) {
            $productCollection->getSelect()->where($sqlCondition);
        }

        return $this;
    }

    /**
     * @inheritDoc
     * @see \Magento\SalesRule\Model\Rule\Condition\Product\Combine::_isValid()
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function _isValid($entity): bool
    {
        if (!$this->getConditions()) {
            return true;
        }

        if (!isset(self::$products[$entity->getId()])) {
            self::$products[$entity->getId()] = $entity;
        }

        $all = $this->getAggregator() === 'all';
        $true = (bool)$this->getValue();

        foreach ($this->getConditions() as $cond) {
            if ($entity instanceof \Magento\Framework\Model\AbstractModel) {
                $validated = $this->validateEntity($cond, $entity);
            } else {
                $validated = $cond->validateByEntityId($entity);
            }
            if ($all && $validated !== $true) {
                return false;
            } elseif (!$all && $validated === $true) {
                return true;
            }
        }

        return $all ? true : false;
    }

    /**
     * @see \Magento\SalesRule\Model\Rule\Condition\Product\Combine::validateEntity()
     */
    private function validateEntity(\Magento\Rule\Model\Condition\AbstractCondition $cond, \Magento\Framework\Model\AbstractModel $entity): bool
    {
        $true = (bool)$this->getValue();
        $validated = !$true;
        foreach ($this->retrieveValidateEntities((string)$cond->getAttributeScope(), $entity) as $validateEntity) {
            $validated = $cond->validate($validateEntity);
            if ($validated === $true) {
                break;
            }
        }

        return $validated;
    }

    /**
     * @see \Magento\SalesRule\Model\Rule\Condition\Product\Combine::retrieveValidateEntities()
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function retrieveValidateEntities(string $attributeScope, \Magento\Framework\Model\AbstractModel $entity): array
    {
        if ($attributeScope === 'parent') {
            $validateEntities = [$entity];

            $parentId = $entity->getParentId();
            if ($parentId) {
                try {
                    $parent = $this->getProduct((int)$parentId);
                } catch (\Exception $e) {
                    $parent = null;
                }

                $validateEntities = $parent ? [$parent] : [$entity];
            }
        } elseif ($attributeScope === 'children') {
            $validateEntities = [];

            $childrenIds = $this->getProductChildrenIds((int)$entity->getId());

            if (count($childrenIds)) {
                $ids = [];
                foreach ($childrenIds as $groupId => $chIds) {
                    if (!is_array($chIds)) {
                        $chIds = [$chIds];
                    }

                    foreach ($chIds as $id) {
                        $ids[] = $id;
                    }
                }

                $this->getProducts($ids);

                foreach ($ids as $id) {
                    $validateEntities[] = self::$products[$id];
                }
            } else {
                $validateEntities = [$entity];
            }
        } else {
            $validateEntities = [$entity];
        }

        return $validateEntities;
    }

    public function getSqlCondition(Collection $productCollection): string
    {
        $sqlCondition = [];

        foreach ($this->getConditions() as $condition) {
            if ($this->getData('aggregator') === 'all') {
                $sql = $condition->getSqlCondition($productCollection);

                if ($sql) {
                    $sqlCondition[] = "({$sql})";
                }
            }
        }

        if (!count($sqlCondition)) {
            return '';
        }

        $sql = $this->getData('aggregator') === 'all'
            ? implode(' AND ', $sqlCondition)
            : implode(' OR ', $sqlCondition);

        return "({$sql})";
    }

    private function getProduct(int $id): Product
    {
        if (!isset(self::$products[$id])) {
            $this->getProducts([$id]);
        }

        return self::$products[$id];
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function getProducts(array $ids)
    {
        if (count(self::$products) > $this->limit) {
            self::$products = [];
        }

        $missed = [];
        foreach ($ids as $id) {
            if (!isset(self::$products[$id])) {
                $missed[] = $id;
            }
        }

        if ($missed) {
            $productCollection = $this->collectionFactory->create();

            $productCollection->getSelect()->where('e.entity_id IN (?)', $missed);

            $this->collectValidatedAttributes($productCollection);

            $storeIds = $this->registry->getCategoryStoreIds();

            $productsData = [];
            $dynamicCategory = $this->registry->getCurrentDynamicCategory();
            if ($dynamicCategory) {
                $productsData = array_fill_keys($missed, []);

                foreach ($dynamicCategory->getAttributes() as $attribute) {
                    $attrCode = is_array($attribute) ? $attribute['code'] : $attribute;

                    $attributeData = $this->attributeService->getAttributeValues($attrCode, $storeIds, $missed);

                    foreach ($attributeData as $prodId => $attrData) {
                        $productsData[$prodId][$attrCode] = $attrData;
                    }
                }
            }

            // do not use product repository due to memory leak
            foreach ($productCollection as $product) {
                foreach ($productsData[$product->getId()] as $attr => $attrValue) {
                    $product->setData($attr, $attrValue);
                }

                self::$products[$product->getId()] = $product;
            }
        }
    }

    private function getProductChildrenIds(int $id): array
    {
        if (!isset(self::$products[$id])) {
            $this->getProduct((int)$id);
        }

        $type = self::$products[$id]->getTypeId();
        if (!self::$products[$id]->getChildrenIds() && $type != 'simple') {
            if ($type == 'bundle') {
                self::$products[$id]->setChildrenIds($this->getBundleChildrenIds($id));
            } elseif ($type == 'configurable') {
                self::$products[$id]->setChildrenIds($this->getConfigChildrenIds($id));
            } else {
                self::$products[$id]->setChildrenIds(self::$products[$id]->getTypeInstance()->getChildrenIds($id));
            }
        }

        return (array)self::$products[$id]->getChildrenIds();
    }

    private function getConfigChildrenIds(int $id): array
    {
        $product = $this->getProduct((int)$id);

        $connection = $product->getResource()->getConnection();

        $select = $connection->select()->from(
            ['l' => $this->resource->getTableName('catalog_product_super_link')],
            ['product_id', 'parent_id']
        )->where(
            'parent_id IN (?)',
            $id
        );

        $childrenIds = [
            0 => array_column(
                $connection->fetchAll($select),
                'product_id',
                'product_id'
            )
        ];

        return $childrenIds;
    }

    private function getBundleChildrenIds(int $id): array
    {
        $product = $this->getProduct((int)$id);

        $connection = $product->getResource()->getConnection();

        $select = $connection->select()->from(
            ['tbl_selection' => $this->resource->getTableName('catalog_product_bundle_selection')],
            ['product_id', 'parent_product_id']
        )->where(
            'parent_product_id = :parent_id'
        );

        $childrenIds = [];
        foreach ($connection->fetchAll($select, ['parent_id' => $id]) as $row) {
            $childrenIds[] = $row['product_id'];
        }

        return array_unique($childrenIds);
    }
}