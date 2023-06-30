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

namespace Mirasvit\DynamicCategory\Model\DynamicCategory;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\Iterator;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Rule\Model\AbstractModel;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Service\AttributeService;
use Mirasvit\DynamicCategory\Service\ReindexService;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Rule extends AbstractModel
{
    const FORM_NAME = 'category_form';

    private $productIds = [];

    private $storeIds = [];

    private $attributeService;

    private $combineFactory;

    private $iterator;

    private $metadataPool;

    private $productFactory;

    private $registry;

    private $reindexService;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Condition\CombineFactory $combineFactory,
        Iterator                 $iterator,
        MetadataPool             $metadataPool,
        ProductFactory           $productFactory,
        Registry                 $registry,
        Context                  $context,
        CoreRegistry             $coreRegistry,
        AttributeService         $attributeService,
        ReindexService           $reindexService,
        FormFactory              $formFactory,
        TimezoneInterface        $localeDate
    ) {
        $this->combineFactory   = $combineFactory;
        $this->iterator         = $iterator;
        $this->metadataPool     = $metadataPool;
        $this->productFactory   = $productFactory;
        $this->registry         = $registry;
        $this->reindexService   = $reindexService;
        $this->attributeService = $attributeService;

        parent::__construct($context, $coreRegistry, $formFactory, $localeDate);
    }

    /**
     * @return \Magento\Rule\Model\Action\Collection
     */
    public function getActionsInstance(): void
    {
    }

    /**
     * @return \Magento\Rule\Model\Condition\Combine
     */
    public function getConditionsInstance(): Condition\Combine
    {
        return $this->combineFactory->create();
    }

    /**
     * @param Collection $collection
     * @return void
     *
     * @throws LocalizedException
     */
    public function applyToCollection(Collection $collection): void
    {
        $ids   = $this->getMatchingProductIds($collection, true);
        $ids[] = 0;

        $collection->addFieldToFilter('entity_id', ['in' => $ids]);
    }

    /**
     * @param Collection $collection
     * @return void
     *
     * @throws LocalizedException
     */
    public function applyToFullCollection(Collection $collection): void
    {
        $ids   = $this->getMatchingProductIds($collection, false);
        $ids[] = 0;

        $collection->addFieldToFilter('entity_id', ['in' => $ids]);
    }

    /**
     * @param Collection $collection
     * @param bool       $limitCollection
     *
     * @return array
     * @throws LocalizedException
     */
    public function getMatchingProductIds(Collection $collection, bool $limitCollection = true): array
    {
        $this->productIds = [];

        $storeIds = $this->getStoreIds();

        $ruleCollection = clone $collection;

        $this->getConditions()->applyConditions($ruleCollection);
        $this->getConditions()->collectValidatedAttributes($ruleCollection);

        $ruleCollection->getSelect()->group('e.entity_id');

        $table = $ruleCollection->getResource()->getTable('catalog_product_super_link');

        $ruleCollection->getSelect()->joinLeft(['cpsl' => $table], 'cpsl.product_id = e.entity_id', ['parent_id' => 'cpsl.parent_id']);

        if ($limitCollection && $ruleCollection->count() > 5000) {
            $this->reindexService->invalidateIndex(['catalog_category_product']);

            throw new LocalizedException(__("The number of products is too high for processing in real-time. Please run 'Category Product' reindex: bin/magento indexer:reindex catalog_category_product"));
        }

        $idCollection = clone $ruleCollection;

        $ids = $idCollection->getAllIds();

        $productsData = [];
        $dynamicCategory = $this->registry->getCurrentDynamicCategory();
        if ($dynamicCategory) {
            $productsData = array_fill_keys($ids, []);

            foreach ($dynamicCategory->getAttributes() as $attribute) {
                $attrCode = is_array($attribute) ? $attribute['code'] : $attribute;

                $attributeData = $this->attributeService->getAttributeValues($attrCode, $storeIds, $ids);

                foreach ($attributeData as $prodId => $attrData) {
                    $productsData[$prodId][$attrCode] = $attrData;
                }
            }
        }

        $this->iterator->walk(
            $ruleCollection->getSelect(),
            [[$this, 'callbackValidateProduct']],
            [
                'product'     => $this->productFactory->create(),
                'productData' => $productsData,
            ]
        );

        $this->productIds = array_unique($this->productIds);

        return $this->productIds;
    }

    /**
     * @param array $args
     * @return void
     */
    public function callbackValidateProduct(array $args): void
    {
        $product = clone $args['product'];
        $product->setData($args['row']);

        $productData = $args['productData'];
        foreach ($productData[$product->getId()] as $attr => $attrValue) {
            $product->setData($attr, $attrValue);
        }

        if ($this->getConditions()->validate($product)) {
            $this->productIds[] = (int)$product->getId();

            if ($product->getParentId() && !in_array((int)$product->getParentId(), $this->productIds)) {
                $this->productIds[] = (int)$product->getParentId();
            }
        }
    }

    public function setStoreIds(array $ids): void
    {
        $this->storeIds = $ids;
    }

    public function getStoreIds(): array
    {
        return $this->storeIds;
    }
}
