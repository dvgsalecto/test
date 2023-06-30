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
 * @version   2.4.33
 * @copyright Copyright (C) 2022 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\SeoMarkup\Block\Rs;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\SeoMarkup\Model\Config\ProductConfig;
use Magento\Framework\View\Element\Template;
use Mirasvit\SeoMarkup\Service\ProductRichSnippetsService;

class Product extends Template
{
    private $registry;

    private $productConfig;

    private $productSnippetService;

    private $store;

    public function __construct(
        ProductConfig $productConfig,
        Registry $registry,
        Context $context,
        ProductRichSnippetsService $productSnippetService
    ) {
        $this->productSnippetService = $productSnippetService;
        $this->store                 = $context->getStoreManager()->getStore();
        $this->registry              = $registry;
        $this->productConfig         = $productConfig;

        parent::__construct($context);
    }

    /**
     *{@inheritDoc}
     */
    protected function _toHtml()
    {
        if (!$this->productConfig->isRsEnabled($this->store)) {
            return false;
        }

        $product = $this->registry->registry('current_product');

        $data = $this->productSnippetService->getJsonData($product);

        if (!$data) {
            return false;
        }

        return '<script type="application/ld+json">' . SerializeService::encode($data) . '</script>';
    }
}
