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
 * @package   mirasvit/module-seo
 * @version   2.6.8
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\SeoMarkup\Block\Rs;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\Seo\Api\Service\TemplateEngineServiceInterface;
use Mirasvit\SeoMarkup\Model\Config\CategoryConfig;
use Mirasvit\SeoMarkup\Service\ProductRichSnippetsService;

class Brand extends Category
{
    const BRAND_DEFAULT_NAME = 'BrandDefaultName';
    const BRAND_DATA         = 'm__BrandData';

    private $store;

    private $categoryConfig;

    private $templateEngineService;

    private $layerResolver;

    private $registry;

    private $moduleManager;

    private $objectManager;

    public function __construct(
        LayerResolver $layerResolver,
        ModuleManager $moduleManager,
        ObjectManagerInterface $objectManager,
        CategoryConfig $categoryConfig,
        ProductCollectionFactory $productCollectionFactory,
        TemplateEngineServiceInterface $templateEngineService,
        Registry $registry,
        Context $context,
        ProductRichSnippetsService $productSnippetService
    ) {
        $this->categoryConfig        = $categoryConfig;
        $this->templateEngineService = $templateEngineService;
        $this->layerResolver         = $layerResolver;
        $this->store                 = $context->getStoreManager()->getStore();
        $this->registry              = $registry;
        $this->moduleManager         = $moduleManager;
        $this->objectManager         = $objectManager;

        parent::__construct(
            $categoryConfig,
            $productCollectionFactory,
            $templateEngineService,
            $registry,
            $context,
            $productSnippetService
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function _toHtml()
    {
        $data = $this->getJsonData();

        if (!$data) {
            return '';
        }

        return '<script type="application/ld+json">' . SerializeService::encode($data) . '</script>';
    }

    public function getJsonData(): ?array
    {
        if (!$this->moduleManager->isEnabled('Mirasvit_Brand')) {
            return null;
        }

        $brandTitle = $this->getBrandTitle();

        if (empty($brandTitle)) {
            return null;
        }

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->layerResolver->get()->getProductCollection()->addAttributeToSelect('*');
        if (strripos($collection->getSelect()->__toString(), 'limit') === false) {
            $pageSize = $this->categoryConfig->getDefaultPageSize($this->store);
            $pageNum  = 1;

            if ($toolbar = $this->getLayout()->getBlock('product_list_toolbar')) {
                $pageSize = $toolbar->getLimit();
            }

            if ($pager = $this->getLayout()->getBlock('product_list_toolbar_pager')) {
                $pageNum = $pager->getCurrentPage();
            }

            $collection->setPageSize($pageSize)->setCurPage($pageNum);
        }

        if (!$collection || !$collection->getSize()) {
            return null;
        }

        return [
            '@context'   => 'http://schema.org',
            '@type'      => 'WebPage',
            'url'        => $this->_urlBuilder->escape($this->_urlBuilder->getCurrentUrl()),
            'mainEntity' => [
                '@context'        => 'http://schema.org',
                '@type'           => 'OfferCatalog',
                'name'            => $brandTitle,
                'url'             => $this->_urlBuilder->escape($this->_urlBuilder->getCurrentUrl()),
                'numberOfItems'   => $collection->getSize(),
                'itemListElement' => $this->getItemList($collection),
            ],
        ];
    }

    private function getBrandTitle(): string
    {
        $brandRegistry = $this->objectManager->get('Mirasvit\Brand\Registry');

        return (string)$brandRegistry->getBrandPage()->getBrandTitle();
    }
}
