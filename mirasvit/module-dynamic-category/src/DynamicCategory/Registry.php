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

namespace Mirasvit\DynamicCategory;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Registry as CoreRegistry;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;

class Registry
{
    private $categoryStoreIds = [];

    private $coreRegistry;

    private $currentDynamicCategory;

    private $currentPreviewDynamicCategory;

    private $getSizeResetGroup;

    private $isReindexCategory;

    private $isSavingProduct;

    private $reindexCategory;

    public function __construct(
        CoreRegistry $coreRegistry
    ) {
        $this->coreRegistry = $coreRegistry;
    }

    public function getCurrentCategory(): ?CategoryInterface
    {
        return $this->coreRegistry->registry('current_category');
    }

    public function setCurrentCategory(?CategoryInterface $category): void
    {
        $this->coreRegistry->unregister('current_category');
        $this->coreRegistry->register('current_category', $category);
    }

    public function getCategory(): ?CategoryInterface
    {
        return $this->coreRegistry->registry('category');
    }

    public function setCategory(?CategoryInterface $category): void
    {
        $this->coreRegistry->unregister('category');
        $this->coreRegistry->register('category', $category);
    }

    public function getReindexCategory(): ?CategoryInterface
    {
        return $this->reindexCategory;
    }

    public function setReindexCategory(?CategoryInterface $category): void
    {
        $this->reindexCategory = $category;
    }

    public function getCurrentDynamicCategory(): ?DynamicCategoryInterface
    {
        return $this->currentDynamicCategory;
    }

    public function setCurrentDynamicCategory(?DynamicCategoryInterface $dynamicCategory): void
    {
        $this->currentDynamicCategory = $dynamicCategory;
    }

    public function getCurrentPreviewDynamicCategory(): ?DynamicCategoryInterface
    {
        return $this->currentPreviewDynamicCategory;
    }

    public function setCurrentPreviewDynamicCategory(?DynamicCategoryInterface $dynamicCategory): void
    {
        $this->currentPreviewDynamicCategory = $dynamicCategory;
    }

    public function getIsGetSizeResetGroup(): ?bool
    {
        return $this->getSizeResetGroup;
    }

    public function setIsGetSizeResetGroup(?bool $flag): void
    {
        $this->getSizeResetGroup = $flag;
    }

    public function isSavingProduct(): ?bool
    {
        return $this->isSavingProduct;
    }

    public function setIsSavingProduct(?bool $flag): void
    {
        $this->isSavingProduct = $flag;
    }

    public function isReindexCategory(): ?bool
    {
        return $this->isReindexCategory;
    }

    public function setIsReindexCategory(?bool $flag): void
    {
        $this->isReindexCategory = $flag;
    }

    public function getCategoryStoreIds(): array
    {
        return $this->categoryStoreIds;
    }

    public function setCategoryStoreIds(array $ids): void
    {
        $this->categoryStoreIds = $ids;
    }
}
