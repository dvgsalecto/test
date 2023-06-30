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

namespace Mirasvit\DynamicCategory\Block\Adminhtml\Category\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended as ProductTab;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Registry;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Product extends ProductTab
{
    private $categoryRepository;

    private $collectionFactory;

    private $config;

    private $productFactory;

    private $registry;

    private $status;

    private $storeManager;

    private $visibility;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ConfigProvider $config,
        Registry $registry,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        Context $context,
        Data $backendHelper,
        ProductFactory $productFactory,
        array $data = [],
        Visibility $visibility = null,
        Status $status = null
    ) {
        parent::__construct($context, $backendHelper, $data);

        $this->categoryRepository = $categoryRepository;
        $this->collectionFactory  = $collectionFactory;
        $this->config             = $config;
        $this->productFactory     = $productFactory;
        $this->registry           = $registry;
        $this->status             = $status;
        $this->storeManager       = $storeManager;
        $this->visibility         = $visibility;
    }

    public function getGridUrl(): string
    {
        return $this->getUrl('catalog/*/grid', ['_current' => true]);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('catalog_category_products');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection(): Product
    {
        if ($this->registry->getCurrentDynamicCategory()) {
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $this->productFactory->create()->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('sku')
                ->addAttributeToSelect('visibility')
                ->addAttributeToSelect('status')
                ->addAttributeToSelect('price');

            $collection->getSelect()->columns(
                [
                    'position' => new \Zend_Db_Expr(0),
                ]
            );

            if ($this->config->getExcludedProductVisibility() == ConfigProvider::EXCLUDED_PRODUCT_VISIBILITY_INVISIBLE) {
                $collection->addAttributeToFilter('visibility', ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);
            }

            $category = $this->registry->getCurrentDynamicCategory();

            $c = $this->categoryRepository->get($category->getCategoryId());

            $categoryWebsiteIds = [];

            $categoryStoreIds   = [0];

            $stores = $this->storeManager->getStores();
            foreach ($stores as $store) {
                if (in_array($store->getRootCategoryId(), $c->getPathIds())) {
                    $categoryWebsiteIds[] = $store->getWebsiteId();
                    $categoryStoreIds[]   = $store->getId();
                }
            }

            $this->registry->setCategoryStoreIds($categoryStoreIds);

            $collection->addWebsiteFilter($categoryWebsiteIds);

            $category->getRule()->setStoreIds($categoryStoreIds);

            $category->getRule()->applyToFullCollection($collection);

            $this->setCollection($collection);
        }

        parent::_prepareCollection();

        return $this;
    }

    protected function _prepareColumns(): Product
    {
        $this->addColumn(
            'entity_id',
            [
                'header'           => __('ID'),
                'sortable'         => true,
                'index'            => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('sku', ['header' => __('SKU'), 'index' => 'sku']);

        $this->addColumn(
            'visibility',
            [
                'header'           => __('Visibility'),
                'index'            => 'visibility',
                'type'             => 'options',
                'options'          => Visibility::getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header'  => __('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => Status::getOptionArray(),
            ]
        );

        $this->addColumn(
            'price',
            [
                'header'        => __('Price'),
                'type'          => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index'         => 'price',
            ]
        );

        $this->addColumn(
            'position',
            [
                'header'   => __('Position'),
                'type'     => 'number',
                'index'    => 'position',
                'editable' => true,
            ]
        );

        return parent::_prepareColumns();
    }
}
