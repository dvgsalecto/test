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

namespace Mirasvit\DynamicCategory\Service;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Query\BatchIteratorInterface;
use Magento\Framework\DB\Query\Generator as QueryGenerator;
use Magento\Framework\DB\Select;
use Magento\Indexer\Model\Indexer\CollectionFactory as IndexerCollectionFactory;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ReindexService
{
    const FIELD_CATEGORY_ID = 'category_id';
    const FIELD_PRODUCT_ID  = 'product_id';
    const FIELD_POSITION    = 'position';

    private $productLimit = 500000;

//    private $categoryProducts = [];

    private $config;

    private $productCollectionFactory;

    private $dynamicCategoryRepository;

    private $categoryRepository;

    private $queryGenerator;

    private $connection;

    private $registry;

    private $urlPersist;

    private $indexerCollectionFactory;

    private $storeManager;

    private $resource;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ConfigProvider            $config,
        ProductCollectionFactory  $productCollectionFactory,
        DynamicCategoryRepository $dynamicCategoryRepository,
        Registry                  $registry,
        UrlPersistInterface       $urlPersist,
        CategoryRepository        $categoryRepository,
        QueryGenerator            $queryGenerator,
        IndexerCollectionFactory  $indexerCollectionFactory,
        StoreManagerInterface     $storeManager,
        ResourceConnection        $resource
    ) {
        $this->config                    = $config;
        $this->productCollectionFactory  = $productCollectionFactory;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
        $this->categoryRepository        = $categoryRepository;
        $this->queryGenerator            = $queryGenerator;
        $this->registry                  = $registry;
        $this->urlPersist                = $urlPersist;
        $this->indexerCollectionFactory  = $indexerCollectionFactory;
        $this->storeManager              = $storeManager;
        $this->resource                  = $resource;
        $this->connection                = $resource->getConnection();
    }

    public function reindexCategory(DynamicCategoryInterface $dynamicCategory): void
    {
        try {
            /** @var \Magento\Catalog\Model\Category $category */
            $category = $this->categoryRepository->get($dynamicCategory->getCategoryId());
        } catch (\Exception $e) {
            // category was removed
            $this->dynamicCategoryRepository->delete($dynamicCategory);

            return;
        }

        $this->registry->setCategory($category);
        $this->registry->setIsReindexCategory(true);

        $this->registry->setCurrentDynamicCategory($dynamicCategory);

        $page = 0;

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
        $productCollection = $this->productCollectionFactory->create();

        $categoryWebsiteIds = [];

        $categoryStoreIds   = [0];

        $stores = $this->storeManager->getStores();
        foreach ($stores as $store) {
            if (in_array($store->getRootCategoryId(), $category->getPathIds())) {
                $categoryWebsiteIds[] = $store->getWebsiteId();
                $categoryStoreIds[]   = $store->getId();
            }
        }

        $this->registry->setCategoryStoreIds($categoryStoreIds);

        $productCollection->addWebsiteFilter($categoryWebsiteIds);

        if ($this->config->getExcludedProductVisibility() == ConfigProvider::EXCLUDED_PRODUCT_VISIBILITY_INVISIBLE) {
            $productCollection->addAttributeToFilter('visibility', ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);
        }

        $size = $productCollection->getSize();
        $max  = ceil($size / $this->productLimit);

        $products = [];
        while ($page <= $max) {
            $products = $products + $this->getProducts($dynamicCategory, $page, $categoryWebsiteIds, $categoryStoreIds);

            $page++;
        }

        if ($products) {
            $category->setStoreId(Store::DEFAULT_STORE_ID);
            $category->setPostedProducts($products);
            $category->save();
        }

        $dynamicCategory->setQueued(false);

        $this->dynamicCategoryRepository->save($dynamicCategory);

        $this->registry->setCategory(null);
        $this->registry->setIsReindexCategory(false);
    }

    private function getProducts(DynamicCategoryInterface $dynamicCategory, int $page, array $categoryWebsiteIds = [], array $categoryStoreIds = []): array
    {
        try {
            /** @var \Magento\Catalog\Model\Category $category */
            $category = $this->categoryRepository->get($dynamicCategory->getCategoryId());
        } catch (\Exception $e) {
            // category was removed
            $this->dynamicCategoryRepository->delete($dynamicCategory);

            return [];
        }

        $indexSelect = $this->getIndexedProductsForCategoryQuery($dynamicCategory->getCategoryId());

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
        $productCollection = $this->productCollectionFactory->create();
        if (!$categoryWebsiteIds) {
            $categoryWebsiteIds = $category->getStore()->getWebsiteId();
        }
        $productCollection->addWebsiteFilter($categoryWebsiteIds);

        $productCollection->getSelect()->limit($this->productLimit, $this->productLimit * $page);

        if ($this->config->getExcludedProductVisibility() == ConfigProvider::EXCLUDED_PRODUCT_VISIBILITY_INVISIBLE) {
            $productCollection->addAttributeToFilter('visibility', ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);
        }

        $products = [];

        $rule = $dynamicCategory->getRule();

        $rule->setStoreIds($categoryStoreIds);
        $rule->applyToFullCollection($productCollection);

        if ($page === 0) {
            $this->removeProducts($productCollection, $indexSelect, (int)$category->getId());
        }

        //some stores exclude already used product on reindex
//        $usedProducts = $category->getPostedProducts();
//        if (!$usedProducts) {
//            $usedProducts = $this->getCategoryProducts((int)$category->getId());
//        }

        $resultSelect = $productCollection->getSelect();

        $resultSelect->reset($resultSelect::COLUMNS);
        $resultSelect->reset($resultSelect::LIMIT_COUNT);
        $resultSelect->reset($resultSelect::LIMIT_OFFSET);

        $resultSelect->columns([
            self::FIELD_CATEGORY_ID => new \Zend_Db_Expr($dynamicCategory->getCategoryId()),
            self::FIELD_PRODUCT_ID  => 'e.entity_id',
            self::FIELD_POSITION    => new \Zend_Db_Expr(0),
        ]);

        $countSelect = clone $resultSelect;
        $countSelect->reset($countSelect::COLUMNS);
        $countSelect->reset($countSelect::LIMIT_COUNT);
        $countSelect->reset($countSelect::LIMIT_OFFSET);
        $countSelect->columns([
            new \Zend_Db_Expr('COUNT(*)'),
        ]);

        $i     = 0;
        $total = $countSelect->query()->fetchColumn();
        if ($total > 0) {
            foreach ($resultSelect->query() as $row) {
//                if (!isset($usedProducts[$row['product_id']])) {
                    $products[$row['product_id']] = $i;

                    $i++;
//                }
            }
        }

        return $products;
    }

    /**
     * @see \Magento\Catalog\Model\Indexer\Category\Product\AbstractAction::prepareSelectsByRange()
     */
    public function prepareSelectsByRange(Select $select, string $field, int $range = 5000): array
    {
        $iterator = $this->queryGenerator->generate(
            $field,
            $select,
            $range,
            BatchIteratorInterface::NON_UNIQUE_FIELD_ITERATOR
        );

        $queries = [];
        foreach ($iterator as $query) {
            $queries[] = $query;
        }

        return $queries;
    }

    public function invalidateIndex(array $indexes): void
    {
        /** @var \Magento\Indexer\Model\Indexer $indexer */
        foreach ($this->indexerCollectionFactory->create() as $indexer) {
            if (in_array($indexer->getId(), $indexes)) {
                $indexer->invalidate();
            }
        }
    }

    private function getIndexedProductsForCategoryQuery(int $id): Select
    {
        $indexSelect = $this->connection->select();
        $indexSelect->from($this->resource->getTableName('catalog_category_product'), self::FIELD_PRODUCT_ID);
        $indexSelect->where(self::FIELD_CATEGORY_ID . ' = ' . $id);

        return $indexSelect;
    }

    private function removeProducts(Collection $productCollection, Select $indexSelect, int $categoryId)
    {
        $collection            = clone $productCollection;
        $productCategorySelect = clone $indexSelect;

        $productCategorySelect->reset($productCategorySelect::COLUMNS);
        $productCategorySelect->reset($productCategorySelect::LIMIT_COUNT);
        $productCategorySelect->reset($productCategorySelect::LIMIT_OFFSET);
        $productCategorySelect->columns(['entity_id', 'product_id']);

        $resultSelect = $collection->getSelect();

        $resultSelect->reset($resultSelect::COLUMNS);
        $resultSelect->reset($resultSelect::LIMIT_COUNT);
        $resultSelect->reset($resultSelect::LIMIT_OFFSET);

        $resultSelect->columns([
            self::FIELD_PRODUCT_ID => 'e.entity_id',
        ]);

        $productCategorySelect->where('product_id' . ' NOT IN(' . $resultSelect->__toString() . ')');

        $batchQueries = $this->prepareSelectsByRange(
            $productCategorySelect,
            'entity_id',
            $this->productLimit
        );

        foreach ($batchQueries as $query) {
            $result = $this->connection->query(
                $query
            );

            $ids = $productIds = [];
            foreach ($result->fetchAll() as $row) {
                $ids[]        = $row['entity_id'];
                $productIds[] = $row['product_id'];
            }

            if ($ids) {
                $this->connection->delete(
                    $this->resource->getTableName('catalog_category_product'),
                    'entity_id in (' . implode(',', $ids) . ')'
                );
                $this->urlPersist->deleteByData(
                    [
                        UrlRewrite::ENTITY_ID   => $productIds,
                        UrlRewrite::ENTITY_TYPE => ProductUrlRewriteGenerator::ENTITY_TYPE,
                        UrlRewrite::METADATA    => SerializeService::encode(['category_id' => (string)$categoryId]),
                    ]
                );
            }
        }
    }

//    private function getCategoryProducts(int $categoryId): array
//    {
//        if (!isset($this->categoryProducts[$categoryId])) {
//            $result = $this->connection->query(
//                'SELECT product_id FROM ' . $this->resource->getTableName('catalog_category_product') .
//                ' WHERE category_id = ' . $categoryId
//            );
//
//            $productIds = [];
//            foreach ($result->fetchAll() as $i => $row) {
//                $productIds[$row['product_id']] = $i;
//            }
//
//            $this->categoryProducts[$categoryId] = $productIds;
//        }
//
//        return $this->categoryProducts[$categoryId];
//    }
}
