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

namespace Mirasvit\DynamicCategory\Service;

use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;
use Magento\Store\Api\GroupRepositoryInterface;
use Magento\Store\Model\StoreManager;

class CategoryService
{
    private $groupRepository;

    private $productResource;

    private $storeManager;

    private $rootCategoryIds = [];

    public function __construct(
        GroupRepositoryInterface $groupRepository,
        ResourceProduct $productResource,
        StoreManager $storeManager
    ) {
        $this->groupRepository = $groupRepository;
        $this->productResource = $productResource;
        $this->storeManager    = $storeManager;
    }

    public function getRootCategoryIds(): array
    {
        if (!$this->rootCategoryIds) {
            $stores = $this->storeManager->getStores();
            foreach ($stores as $store) {
                $storeGroup = $this->groupRepository->get($store->getStoreGroupId());

                if (!isset($this->rootCategoryIds[$storeGroup->getRootCategoryId()])) {
                    $this->rootCategoryIds[$storeGroup->getRootCategoryId()] = [$storeGroup->getDefaultStoreId()];
                } else {
                    $this->rootCategoryIds[$storeGroup->getRootCategoryId()][] = $storeGroup->getDefaultStoreId();
                }
            }
        }

        return $this->rootCategoryIds;
    }

    public function prepareConditions(array $ruleData): array
    {
        $productAttributes = $this->productResource->loadAllAttributes()->getAttributesByCode();

        foreach ($ruleData['conditions'] as $k => $cond) {
            if (strpos($cond['type'], 'ProductCondition') && !empty($cond['attribute'])) {
                foreach ($productAttributes as $attribute) {
                    /* @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
                    if ($cond['attribute'] == $attribute->getAttributeCode() &&
                        $attribute->getFrontendInput() == 'multiselect'
                    ) {
                        $ruleData['conditions'][$k]['is_multiselect'] = true;

                        break;
                    }
                }
            }
        }

        return $ruleData;
    }
}
