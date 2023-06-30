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
 * @version   1.2.24
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\DynamicCategory\Model\DynamicCategory\Condition\SmartCondition;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Eav\Model\Entity\AttributeFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Select;
use Magento\Framework\Model\AbstractModel;
use Magento\Rule\Model\Condition\Context;
use Mirasvit\DynamicCategory\Model\DynamicCategory\Condition\QueryBuilder;

class OnSaleCondition extends AbstractCondition
{
    const ATTR_PRICE       = 'price';
    const ATTR_FINAL_PRICE = 'final_price';

    private $attributeFactory;

    private $queryBuilder;

    private $resource;

    public function __construct(
        AttributeFactory $attributeFactory,
        ResourceConnection $resource,
        QueryBuilder $queryBuilder,
        Context $context,
        array $data = []
    ) {
        $this->attributeFactory = $attributeFactory;
        $this->resource         = $resource;
        $this->queryBuilder     = $queryBuilder;

        parent::__construct($context, $data);
    }

    public function getAttributeElementHtml(): string
    {
        return (string)__('Has Active Special Price');
    }

    public function getInputType(): string
    {
        return 'select';
    }

    public function getValueElementType(): string
    {
        return 'select';
    }

    public function getValueSelectOptions(): array
    {
        return [
            ['value' => 1, 'label' => 'Yes'],
            ['value' => 0, 'label' => 'No'],
        ];
    }

    public function collectValidatedAttributes(Collection $collection): self
    {
        $linkAlias = 'catalog_product_super_link';

        if ($this->queryBuilder->isJoined($collection->getSelect(), $linkAlias)) {
            return $this;
        }

        $collection->getSelect()->joinLeft(
            [$linkAlias => $this->resource->getTableName($linkAlias)],
            'e.entity_id = ' . $linkAlias . '.parent_id',
            []
        );

        $conditions = [
            '(' . $this->joinSpecialPrice($collection->getSelect(), '_primary', 'e.entity_id') . ')',
            '(' . $this->joinSpecialPrice($collection->getSelect(), '_child', $linkAlias . '.product_id') . ')',
            '(' . $this->joinRulePrice($collection->getSelect(), 'e.entity_id') . ')',
        ];

        $collection->getSelect()->columns(new \Zend_Db_Expr('IF (' . implode(' OR ', $conditions) . ', 1, 0) as has_special_price'));

        $collection->getSelect()->group('e.entity_id');

        return $this;
    }

    public function validate(AbstractModel $model): bool
    {
        return $this->validateAttribute($model->getData('has_special_price'));
    }

    private function joinSpecialPrice(Select $select, string $index, string $mainTableAccessor): string
    {
        $conditions = [];

        /* @var \Magento\Eav\Model\Entity\Attribute $attribute */
        $attribute = $this->attributeFactory->create()->loadByCode(Product::ENTITY, 'special_price');
        $spAlias   = 'special_price' . $index;

        $select->joinLeft(
            [$spAlias => $attribute->getBackendTable(),],
            $mainTableAccessor . ' = ' . $spAlias . '.entity_id AND ' . $spAlias . '.attribute_id = ' . $attribute->getId(),
            ['value']
        );
        $conditions[] = $spAlias . '.value > 0';

        $attribute = $this->attributeFactory->create()->loadByCode(Product::ENTITY, 'special_from_date');
        $spfAlias  = 'special_price_from' . $index;
        $select->joinLeft(
            [$spfAlias => $attribute->getBackendTable(),],
            $mainTableAccessor . ' = ' . $spfAlias . '.entity_id AND ' . $spfAlias . '.attribute_id = ' . $attribute->getId() . ' AND ' . $spfAlias . '.value > 0',
            []
        );
        $conditions[] = '(' . $spfAlias . '.value IS NULL OR ' . $spfAlias . '.value < now())';

        $attribute = $this->attributeFactory->create()->loadByCode(Product::ENTITY, 'special_to_date');
        $sptAlias  = 'special_price_to' . $index;

        $select->joinLeft(
            [$sptAlias => $attribute->getBackendTable(),],
            $mainTableAccessor . ' = ' . $sptAlias . '.entity_id AND ' . $sptAlias . '.attribute_id = ' . $attribute->getId() . ' AND ' . $sptAlias . '.value > 0',
            []
        );
        $conditions[] = '(' . $sptAlias . '.value IS NULL OR ' . $sptAlias . '.value >= now())';

        return implode(' AND ', $conditions);
    }

    private function joinRulePrice(Select $select, string $mainTableAccessor): string
    {
        $select->joinLeft(
            ['index_price' => $this->resource->getTableName('catalog_product_index_price')],
            $mainTableAccessor . ' = ' . 'index_price.entity_id',
            []
        );

        return 'index_price.price > index_price.final_price';
    }
}
