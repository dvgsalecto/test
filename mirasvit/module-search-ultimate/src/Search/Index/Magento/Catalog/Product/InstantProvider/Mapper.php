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
 * @package   mirasvit/module-search-ultimate
 * @version   2.1.0
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Search\Index\Magento\Catalog\Product\InstantProvider;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Mirasvit\Search\Service\MapperService;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Mapper
{
    const IN_STOCK = 2;

    const OUT_OF_STOCK = 1;

    const UNSET_STOCK = 0;

    private $attributeIds = [];

    private $pkField      = '';

    private $resource;

    private $mapperService;

    private $imageHelper;


    private $pricingHelper;

    public function __construct(
        ResourceConnection $resource,
        MapperService      $mapperService,
        ImageHelper        $imageHelper,
        PricingHelper      $pricingHelper
    ) {
        $this->resource      = $resource;
        $this->mapperService = $mapperService;
        $this->imageHelper   = $imageHelper;
        $this->pricingHelper = $pricingHelper;
    }

    public function mapProductSku(int $storeId, array $productIds): array
    {
        $data = $this->resource->getConnection()->fetchPairs(
            $this->resource->getConnection()
                ->select()
                ->from([$this->resource->getTableName('catalog_product_entity')], ['entity_id', 'sku'])
                ->where('entity_id IN(?)', $productIds)
        );

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = '';
        }

        foreach ($data as $productId => $sku) {
            $map[$productId] = $this->mapperService->clearString((string)$sku);
        }

        return $map;
    }

    public function mapProductName(int $storeId, array $productIds): array
    {
        $data = $this->attributeSelectQuery($storeId, $productIds, 'name', 'varchar');

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = '';
        }

        foreach ($data as $productId => $name) {
            $map[$productId] = $this->mapperService->clearString((string)$name);
        }

        return $map;
    }

    public function mapProductUrl(int $storeId, array $productIds): array
    {
        $data = $this->resource->getConnection()->fetchPairs(
            $this->resource->getConnection()
                ->select()
                ->from([$this->resource->getTableName('url_rewrite')], ['entity_id', 'request_path'])
                ->where('entity_id IN(?)', $productIds)
                ->where('entity_type = ? ', ProductUrlRewriteGenerator::ENTITY_TYPE)
                ->where('store_id IN(?)', [0, $storeId])
                ->where('redirect_type = 0')
                ->group('entity_id')
        );

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = $this->mapperService->getBaseUrl($storeId) . 'catalog/product/view/id/' . $productId . '/';
        }

        foreach ($data as $productId => $requestPath) {
            $map[$productId] = $this->mapperService->getBaseUrl($storeId) . $requestPath;
        }

        return $map;
    }

    public function mapProductImage(int $storeId, array $productIds): array
    {
        $emulation = ObjectManager::getInstance()->get('\Magento\Store\Model\App\Emulation');
        $emulation->startEnvironmentEmulation($storeId, 'frontend', true);

        $data = $this->attributeSelectQuery($storeId, $productIds, 'thumbnail', 'varchar');

        $placeholder = $this->imageHelper->getDefaultPlaceholderUrl('thumbnail');

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = $placeholder;
        }

        foreach ($data as $productId => $path) {
            if ($path == '' || $path == 'no_selection') {
                continue;
            }

            $image = (string)$this->imageHelper->init(null, 'upsell_products_list')
                ->setImageFile($path)
                ->getUrl();

            if ($image == '') {
                $image = $placeholder;
            }

            $map[$productId] = $image;
        }

        $emulation->stopEnvironmentEmulation();

        return $map;
    }

    public function mapProductPrice(int $storeId, array $productIds): array
    {
        $data = $this->resource->getConnection()->fetchAll(
            $this->resource->getConnection()
                ->select()
                ->from(['cpip' => $this->resource->getTableName('catalog_product_index_price')], ['*'])
                ->join(['s' => $this->resource->getTableName('store')], 's.website_id = cpip.website_id', [])
                ->where('entity_id IN(?)', $productIds)
                ->where('s.store_id = ?', $storeId)
                ->group('entity_id')
        );

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = '';
        }

        foreach ($data as $item) {
            $productId = $item['entity_id'];

            $price = 0;
            if ($item['max_price'] != 0) {
                $price = $item['max_price'];
            }
            if ($item['min_price'] != 0) {
                $price = $item['min_price'];
            }
            if ($item['final_price'] != 0) {
                $price = $item['final_price'];
            }

            if ($price <= 0) {
                continue;
            }

            $map[$productId] = $this->pricingHelper->currencyByStore($price, $storeId, true, false);
        }

        return $map;
    }

    public function mapProductDescription(int $storeId, array $productIds): array
    {
        $descriptionData = $this->attributeSelectQuery($storeId, $productIds, 'description', 'text');

        $shortDescriptionData = $this->attributeSelectQuery($storeId, $productIds, 'short_description', 'text');

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = '';

            if (isset($descriptionData[$productId]) && $descriptionData[$productId] != '') {
                $map[$productId] = $this->mapperService->clearString(
                    (string)$descriptionData[$productId]
                );
            } elseif (isset($shortDescriptionData[$productId]) && $shortDescriptionData[$productId] != '') {
                $map[$productId] = $this->mapperService->clearString(
                    (string)$shortDescriptionData[$productId]
                );
            }
        }

        return $map;
    }

    public function mapProductRating(int $storeId, array $productIds): array
    {
        $data = $this->resource->getConnection()->fetchPairs(
            $this->resource->getConnection()->select()->from(
                [$this->resource->getTableName('rating_option_vote_aggregated')],
                [
                    'entity_pk_value',
                    'value' => new \Zend_Db_Expr('AVG(percent)'),
                ]
            )->where('entity_pk_value IN (?)', $productIds)
                ->where('store_id = ?', $storeId)
                ->group('entity_pk_value')
        );

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = 0;
        }

        foreach ($data as $productId => $rating) {
            $map[$productId] = $rating;
        }

        return $map;
    }

    public function mapProductReviews(int $storeId, array $productIds): array
    {
        $data = $this->resource->getConnection()->fetchPairs(
            $this->resource->getConnection()->select()->from(
                [$this->resource->getTableName('review')],
                [
                    'entity_id',
                    'value' => new \Zend_Db_Expr('COUNT(review_id)'),
                ]
            )->where('status_id=1')
                ->where('entity_id IN (?)', $productIds)
                ->group('entity_id')
        );

        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = 0;
        }

        foreach ($data as $productId => $reviews) {
            $map[$productId] = $reviews;
        }

        return $map;
    }

    public function mapProductCart(int $storeId, array $productIds): array
    {
        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = $this->mapperService->getBaseUrl($storeId) . 'searchautocomplete/cart/add/id/' . $productId;
        }

        $stockMap = $this->mapProductStockStatus($storeId, $productIds);

        foreach ($stockMap as $productId => $stockStatus) {
            if ($stockStatus == self::OUT_OF_STOCK) {
                $map[$productId] = '';
            }
        }

        return $map;
    }

    public function mapProductStockStatus(int $storeId, array $productIds): array
    {
        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = self::UNSET_STOCK;
        }

        //        if ($this->moduleManager->isEnabled('Magento_Inventory')) {
        //            $connection = $this->resource->getConnection();
        //
        //            $select = $connection->select();
        //
        //            $select->from(
        //                ['store' => $this->resource->getTableName('store')],
        //                ['website_id', 'store_id']
        //            )->joinInner(
        //                ['store_website' => $this->resource->getTableName('store_website')],
        //                'store.website_id = store_website.website_id',
        //                null
        //            )->joinInner(
        //                ['stock' => $this->resource->getTableName('inventory_stock_sales_channel')],
        //                'store_website.code = stock.code',
        //                null
        //            )->joinInner(
        //                ['source_link' => $this->resource->getTableName('inventory_source_stock_link')],
        //                'stock.stock_id = source_link.stock_id',
        //                ['stock_id']
        //            )->where('store.store_id = ?', $storeId);
        //
        //            $stmt = $connection->query($select);
        //
        //            foreach ($stmt->fetchAll() as $row) {
        //                $stockSelect = $connection->select();
        //                $stockId     = $row['stock_id'];
        //
        //                if ($connection->isTableExists($this->resource->getTableName("inventory_stock_$stockId"))) {
        //                    if ($connection->tableColumnExists($this->resource->getTableName("inventory_stock_$stockId"), 'product_id')) {
        //                        $stockSelect->from(
        //                            ['stock' => $this->resource->getTableName("inventory_stock_$stockId")],
        //                            ['value' => 'is_salable', 'entity_id' => 'product_id']
        //                        )->where('stock.product_id IN (?)', $productIds);
        //                    } else {
        //                        $stockSelect->from(
        //                            ['stock' => $this->resource->getTableName("inventory_stock_$stockId")],
        //                            ['value' => 'is_salable']
        //                        )->joinInner(
        //                            ['e' => $this->resource->getTableName('catalog_product_entity')],
        //                            'e.sku = stock.sku',
        //                            ['entity_id']
        //                        )->where('e.entity_id IN (?)', $productIds);
        //                    }
        //                } else {
        //                    $stockSelect->from(
        //                        ['stock' => $this->resource->getTableName("cataloginventory_stock_item")],
        //                        ['value' => 'is_in_stock']
        //                    )->joinInner(
        //                        ['e' => $this->resource->getTableName('catalog_product_entity')],
        //                        'e.entity_id = stock.product_id',
        //                        ['entity_id']
        //                    )->where('e.entity_id IN (?)', $productIds);
        //                }
        //
        //                foreach ($connection->fetchAll($stockSelect) as $item) {
        //                    $map[$item['entity_id']] = $item['value'] == 1 ? self::IN_STOCK : self::OUT_OF_STOCK;
        //                }
        //            }
        //        } else {
        $data = $this->resource->getConnection()->fetchPairs(
            $this->resource->getConnection()->select()
                ->from(
                    ['e' => $this->resource->getTableName('catalog_product_entity')],
                    ['entity_id']
                )->joinInner(
                    ['stock' => $this->resource->getTableName('cataloginventory_stock_status')],
                    'stock.product_id = e.entity_id',
                    ['stock_status']
                )
                ->where('e.entity_id IN (?)', $productIds)
                ->group('e.entity_id')
        );

        foreach ($data as $productId => $stockStatus) {
            $map[$productId] = $stockStatus == 1 ? self::IN_STOCK : self::OUT_OF_STOCK;
        }

        //        }

        return $map;
    }

    private function attributeSelectQuery(int $storeId, array $productIds, string $attribute, string $type): array
    {
        $map = [];
        foreach ($productIds as $productId) {
            $map[$productId] = '';
        }

        $mainTable = 'catalog_product_entity_' . $type;

        foreach ([$storeId, 0] as $sid) {
            $data = $this->resource->getConnection()->fetchPairs(
                $this->resource->getConnection()
                    ->select()
                    ->from(['ev' => $this->resource->getTableName($mainTable)], [$this->getPkField(), 'value'])
                    ->where('ev.attribute_id = ?', $this->getAttributeId($attribute))
                    ->where('ev.store_id = ?', $sid)
                    ->where(sprintf('ev.%1$s IN(?)', $this->getPkField()), $productIds)
                    ->order('ev.store_id')
                    ->group('ev.' . $this->getPkField())
            );
            foreach ($data as $productId => $value) {
                if ($map[$productId] == '') {
                    $map[$productId] = $value;
                }
            }
        }

        return $map;
    }

    private function getAttributeId(string $attributeCode): int
    {
        if (count($this->attributeIds) == 0) {
            $this->attributeIds = $this->resource->getConnection()->fetchPairs(
                $this->resource->getConnection()->select()
                    ->from(['ea' => $this->resource->getTableName('eav_attribute')], ['attribute_code', 'attribute_id'])
                    ->joinLeft(['eet' => $this->resource->getTableName('eav_entity_type')], 'eet.entity_type_id = ea.entity_type_id', [])
                    ->where('eet.entity_type_code = ?', 'catalog_product')
            );
        }

        return (int)$this->attributeIds[$attributeCode];
    }

    private function getPkField(): string
    {
        if ($this->pkField == '') {
            $this->pkField = (string)$this->resource->getConnection()->getAutoIncrementField($this->resource->getTableName('catalog_product_entity'));
        }

        return $this->pkField;
    }
}
