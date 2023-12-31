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
 * @version   2.0.97
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\Search\Index\Magento\Catalog\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Review\Model\ResourceModel\Review\Summary\CollectionFactory as SummaryCollectionFactory;
use Mirasvit\Search\Index\AbstractInstantProvider;
use Mirasvit\Search\Service\IndexService;
use Mirasvit\SearchAutocomplete\Model\ConfigProvider;

class InstantProvider extends AbstractInstantProvider
{
    private $mapper;

    private $summaryFactory;

    private $productCollectionFactory;

    private $configProvider;

    private $reviews = [];

    public function __construct(
        InstantProvider\Mapper   $mapper,
        SummaryCollectionFactory $summaryFactory,
        ProductCollectionFactory $productCollectionFactory,
        IndexService             $indexService,
        ConfigProvider           $configProvider
    ) {
        $this->mapper                   = $mapper;
        $this->summaryFactory           = $summaryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->configProvider           = $configProvider;

        parent::__construct($indexService);
    }

    public function getItems(int $storeId, int $limit, int $page = 1): array
    {
        /** @var \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $collection */
        $collection = $this->getCollection($limit, $page)
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('short_description')
            ->addAttributeToSelect('description')
            ->setOrder('relevance');

        $this->prepareRatingData($collection->getAllIds(), $storeId);

        $items = [];

        foreach ($collection as $product) {
            $items[] = $this->mapProduct($product, $storeId);
        }

        return $items;
    }

    public function getSize(int $storeId): int
    {
        return $this->getCollection(0)->getSize();
    }

    public function map(array $documentData, int $storeId): array
    {
        $productIds = array_keys($documentData);

        $productCollection = $this->productCollectionFactory->create()
            ->setStoreId($storeId)
            ->addAttributeToSelect('*')
            ->addFieldToFilter('entity_id', ['in' => $productIds])
            ->addStoreFilter($storeId);

        $this->prepareRatingData($productIds, $storeId);

        $applyMultipleCurrencies = $this->configProvider->isMulticurrencyPriceEnabled();
        foreach ($productCollection as $product) {
            $documentData[$product->getId()]['_instant'] = $this->mapProduct($product, $storeId, $applyMultipleCurrencies);
        }

        unset($productCollection);

        return $documentData;
    }

    private function prepareRatingData(array $productIds, int $storeId): void
    {
        $reviewsCollection = $this->summaryFactory->create()
            ->addEntityFilter($productIds)
            ->addStoreFilter($storeId)
            ->load();

        /** @var \Magento\Review\Model\Review\Summary $reviewSummary */
        foreach ($reviewsCollection as $reviewSummary) {
            $this->reviews[$reviewSummary->getData('entity_pk_value')] = $reviewSummary;
        }
    }

    private function mapProduct(ProductInterface $product, int $storeId, ?bool $applyMultipleCurrencies = false): array
    {
        $price = $this->mapper->getPrice($product, $storeId, $applyMultipleCurrencies);
        if (empty($price)) {
            $price = '';
        }

        if (!$applyMultipleCurrencies && is_array($price)) {
            $price = array_values($price)[0];
        }

        return [
            'name'         => $this->mapper->getProductName($product),
            'url'          => $this->mapper->getProductUrl($product, $storeId),
            'sku'          => $this->mapper->getProductSku($product),
            'description'  => $this->mapper->getDescription($product),
            'image'        => $this->mapper->getProductImage($product, $storeId),
            'price'        => $price,
            'rating'       => $this->mapper->getRating($product, $storeId, $this->reviews),
            'cart'         => $this->mapper->getCart($product, $storeId),
            'stock_status' => $this->mapper->getStockStatus($product, $storeId),
        ];
    }
}
