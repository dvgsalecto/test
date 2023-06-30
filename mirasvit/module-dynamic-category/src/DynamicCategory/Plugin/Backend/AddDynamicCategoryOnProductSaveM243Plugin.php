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

namespace Mirasvit\DynamicCategory\Plugin\Backend;

use Magento\Catalog\Helper\Product as ProductHelper;
use Magento\Catalog\Model\Indexer\Product\Flat\Processor;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Indexer\IndexerRegistry;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Registry;
use Magento\Catalog\Api\CategoryLinkManagementInterface;

/**
 * @see Product::save()
 */
class AddDynamicCategoryOnProductSaveM243Plugin
{
    private $categoryLinkManagement;

    private $configProvider;

    private $indexerRegistry;

    private $processor;

    private $productHelper;

    private $productMetadata;

    private $registry;

    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        ConfigProvider $configProvider,
        IndexerRegistry $indexerRegistry,
        Processor $processor,
        ProductHelper $productHelper,
        ProductMetadataInterface $productMetadata,
        Registry $registry
    ) {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->configProvider         = $configProvider;
        $this->indexerRegistry        = $indexerRegistry;
        $this->processor              = $processor;
        $this->productHelper          = $productHelper;
        $this->productMetadata        = $productMetadata;
        $this->registry               = $registry;
    }

    public function afterSave(Product $subject, Product $product): ?Product
    {
        if (
            version_compare($this->productMetadata->getVersion(), "2.4.2", "<") ||
            !$this->registry->isSavingProduct()
        ) {
            return $product;
        }

        $newCategories = (array_diff((array)$product->getCategoryIds(), (array)$product->getOrigData('category_ids')));

        $this->registry->setNewCategoryIds($newCategories);

        $this->categoryLinkManagement->assignProductToCategories(
            $product->getSku(),
            $product->getCategoryIds()
        );

        return $product;
    }
}
