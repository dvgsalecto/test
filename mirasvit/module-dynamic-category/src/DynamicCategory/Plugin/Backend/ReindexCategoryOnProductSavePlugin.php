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

namespace Mirasvit\DynamicCategory\Plugin\Backend;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Indexer\Product\Category;
use Magento\Framework\Indexer\IndexerRegistry;
use Mirasvit\DynamicCategory\Model\ConfigProvider;

/**
 * @see CategoryLinkManagementInterface::assignProductToCategories()
 * Enable if need to reindex after product save
 */
class ReindexCategoryOnProductSavePlugin
{
    const FIELD_IS_DYNAMIC_CATEGORY = 'is_dynamic_category';

    private $configProvider;

    private $indexerRegistry;

    private $productRepository;

    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * @param CategoryLinkManagementInterface $subject
     * @param bool                            $result
     * @param string                          $productSku
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterAssignProductToCategories(CategoryLinkManagementInterface $subject, bool $result, string $productSku): bool
    {
        $product = $this->getProductRepository()->get($productSku);

        $productCategoryIndexer = $this->getIndexerRegistry()->get(Category::INDEXER_ID);
        if (!$productCategoryIndexer->isScheduled()) {
            $productCategoryIndexer->reindexRow($product->getId());
        }

        return $result;
    }

    private function getProductRepository(): ProductRepositoryInterface
    {
        if (null === $this->productRepository) {
            $this->productRepository = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(ProductRepositoryInterface::class);
        }
        return $this->productRepository;
    }

    private function getIndexerRegistry(): IndexerRegistry
    {
        if (null === $this->indexerRegistry) {
            $this->indexerRegistry = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(IndexerRegistry::class);
        }
        return $this->indexerRegistry;
    }
}
