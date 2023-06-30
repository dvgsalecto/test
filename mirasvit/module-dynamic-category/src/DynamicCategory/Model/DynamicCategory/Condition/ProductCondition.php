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

namespace Mirasvit\DynamicCategory\Model\DynamicCategory\Condition;

use Magento\Backend\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\CatalogRule\Model\Rule\Condition\Product as RuleConditionProduct;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection;
use Magento\Framework\Locale\FormatInterface;
use Magento\Rule\Model\Condition\Context;

/**
 * @method string getPrefix()
 * @method string getId()
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProductCondition extends RuleConditionProduct
{
    const PATTERN_CODE = '!%!';

    private $queryBuilder;

    public function __construct(
        QueryBuilder $queryBuilder,
        Context $context,
        Data $backendData,
        Config $config,
        ProductFactory $productFactory,
        ProductRepositoryInterface $productRepository,
        Product $productResource,
        Collection $attrSetCollection,
        FormatInterface $localeFormat
    ) {
        $this->queryBuilder = $queryBuilder;

        parent::__construct($context, $backendData, $config, $productFactory, $productRepository, $productResource, $attrSetCollection, $localeFormat);
    }

    public function getDefaultOperatorOptions()
    {
        $operators = parent::getDefaultOperatorOptions();

        $operators[self::PATTERN_CODE] = __('pattern');

        return $operators;
    }

    public function getAttribute(): string
    {
        $attribute = $this->getData('attribute');
        if (strpos($attribute, '::') !== false) {
            list(, $attribute) = explode('::', $attribute);
        }

        return $attribute;
    }

    public function setAttribute(string $value)
    {
        if (strpos($value, '::') !== false) {
            list($scope, $attribute) = explode('::', $value);
            $this->setData('attribute_scope', $scope);
            $this->setData('attribute', $attribute);
        } else {
            $this->setData('attribute', $value);
        }
    }

    public function getAttributeName()
    {
        $attribute = $this->getAttribute();
        if ($this->getAttributeScope()) {
            $attribute = $this->getAttributeScope() . '::' . $attribute;
        }

        return $this->getAttributeOption($attribute);
    }

    public function loadAttributeOptions()
    {
        $productAttributes = $this->_productResource->loadAllAttributes()->getAttributesByCode();

        $attributes = [];
        foreach ($productAttributes as $attribute) {
            /* @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
            if (!$attribute->isAllowedForRuleCondition()
                || !$attribute->getDataUsingMethod($this->_isUsedForRuleProperty)
            ) {
                continue;
            }
            $frontLabel                                                = $attribute->getFrontendLabel();
            $attributes[$attribute->getAttributeCode()]                = $frontLabel;
            $attributes['parent::' . $attribute->getAttributeCode()]   = $frontLabel . __('(Parent Only)');
            $attributes['children::' . $attribute->getAttributeCode()] = $frontLabel . __('(Children Only)');
        }

        $this->_addSpecialAttributes($attributes);

        asort($attributes);
        $this->setAttributeOption($attributes);

        return $this;
    }

    public function getAttributeElementHtml()
    {
        $html = parent::getAttributeElementHtml() .
            $this->getAttributeScopeElement()->getHtml();

        return $html;
    }

    private function getAttributeScopeElement(): \Magento\Framework\Data\Form\Element\AbstractElement
    {
        return $this->getForm()->addField(
            $this->getPrefix() . '__' . $this->getId() . '__attribute_scope',
            'hidden',
            [
                'name'           => $this->elementName . '[' . $this->getPrefix() . '][' . $this->getId() . '][attribute_scope]',
                'value'          => $this->getAttributeScope(),
                'no_span'        => true,
                'class'          => 'hidden',
                'data-form-part' => $this->getFormName(),
            ]
        );
    }

    public function getDefaultOperatorInputByType(): array
    {
        return [
            'string'      => ['==', '!=', '>=', '>', '<=', '<', '{}', '!{}', '()', '!()', self::PATTERN_CODE],
            'numeric'     => ['==', '!=', '>=', '>', '<=', '<', '()', '!()'],
            'date'        => ['==', '>=', '<='],
            'select'      => ['==', '!=', '<=>'],
            'boolean'     => ['==', '!=', '<=>'],
            'multiselect' => ['()', '!()', '{}', '!{}'],
            'category'    => ['()', '!()'],
            'grid'        => ['()', '!()'],
        ];
    }

    public function getSqlCondition(ProductCollection $collection): string
    {
        $value = is_array($this->getValue()) ? implode(',', $this->getValue()) : (string)$this->getValue();

        $attribute = $this->getAttribute();

        $buildin = ['sku', 'attribute_set_id'];
        if (in_array($attribute, $buildin)) {
            return $this->queryBuilder->buildCondition(
                $collection->getSelect(),
                $this->getAttribute(),
                $this->getOperator(),
                $value
            );
        } else {
            return '';
        }
    }

    /**
     * @param ProductCollection $productCollection
     *
     * @return $this|RuleConditionProduct
     */
    public function collectValidatedAttributes($productCollection)
    {
//        $attribute = $this->getAttribute();
//
//        if ($this->queryBuilder->isJoined($productCollection->getSelect(), $attribute)) {
//            return $this;
//        }
//
//        if ('quantity_and_stock_status' != $attribute) {
//
//            if ($productCollection->getEntity()->getAttribute($attribute)) {
//                return parent::collectValidatedAttributes($productCollection);
//            }
//        }

        return $this;
    }

    public function getJsFormObject(): string
    {
        return 'rule_dynamic_category_conditions_fieldset';
    }

    protected function _addSpecialAttributes(array &$attributes): void
    {
        parent::_addSpecialAttributes($attributes);

        $frontLabel = (string)__('Type');
        $attrCode   = 'type_id';

        $attributes['type_id']                = $frontLabel;
        $attributes['parent::' . $attrCode]   = $frontLabel . __('(Parent Only)');
        $attributes['children::' . $attrCode] = $frontLabel . __('(Children Only)');
    }

    protected function _prepareValueOptions(): self
    {
        if ($this->getAttribute() === 'type_id') {
            return $this;
        }

        return parent::_prepareValueOptions();
    }

    public function loadArray($arr)
    {
        parent::loadArray($arr);

        $this->setAttributeScope($arr['attribute_scope'] ?? null);
        $this->setIsMultiselect($arr['is_multiselect'] ?? null);

        return $this;
    }

    public function asArray(array $arrAttributes = [])
    {
        $out = parent::asArray($arrAttributes);

        $out['attribute_scope'] = $this->getAttributeScope();
        $out['is_multiselect']  = $this->getIsMultiselect();

        return $out;
    }

    public function validateAttribute($validatedValue)
    {
        if ($this->getIsMultiselect() && is_string($validatedValue)) {
            $validatedValue = explode(',', $validatedValue);
        }
        $option = $this->getOperatorForValidate();

        if ($option == self::PATTERN_CODE) {
            $validatePattern = $this->getValueParsed();

            $result = (bool)preg_match('~' . $validatePattern . '~iu', $validatedValue);
        } else {
            $result = parent::validateAttribute($validatedValue);
        }

        return $result;
    }
}
