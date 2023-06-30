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

namespace Mirasvit\DynamicCategory\Plugin\Api;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;

/**
 * @see ProductRepositoryInterface::save()
 */
class AddDynamicCategoryOnProductSavePlugin
{
    private $collectionFactory;

    private $configProvider;

    private $dynamicCategoryRepository;

    private $linkManagement;

    private $registry;

    public function __construct(
        CategoryLinkManagementInterface $linkManagement,
        CollectionFactory $collectionFactory,
        ConfigProvider $configProvider,
        DynamicCategoryRepository $dynamicCategoryRepository,
        Registry $registry
    ) {
        $this->linkManagement            = $linkManagement;
        $this->collectionFactory         = $collectionFactory;
        $this->configProvider            = $configProvider;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
        $this->registry                  = $registry;
    }

    public function afterSave(ProductRepositoryInterface $subject, ProductInterface $product): ?ProductInterface
    {
        $categoryIds = $product->getCategoryIds();
        $productSku  = $product->getSku();

        $collection = $this->dynamicCategoryRepository->getCollection()
            ->addFieldToFilter(DynamicCategoryInterface::IS_ACTIVE, 1);

        $dynamicCategoryIds = $collection->getColumnValues(DynamicCategoryInterface::CATEGORY_ID);

        // exclude dynamic categories
        $newCategoryIds = [];
        foreach ($categoryIds as $categoryId) {
            if (!in_array($categoryId, $dynamicCategoryIds)) {
                $newCategoryIds[] = $categoryId;
            }
        }

        /** @var DynamicCategoryInterface $dynamicCategory */
        foreach ($collection as $dynamicCategory) {
            $this->registry->setCurrentDynamicCategory($dynamicCategory);

            $productCollection = $this->collectionFactory->create();
            $productCollection->addFieldToFilter(ProductInterface::SKU, $productSku);

            $dynamicCategory->getRule()->applyToCollection($productCollection);

            if ($productCollection->count() > 0) {
                $newCategoryIds[] = $dynamicCategory->getCategoryId();
            }

            $this->registry->setCurrentDynamicCategory(null);
        }

        if ($newCategoryIds) {
            $this->linkManagement->assignProductToCategories($product->getSku(), $newCategoryIds);
        }

        return $product;
    }
}
