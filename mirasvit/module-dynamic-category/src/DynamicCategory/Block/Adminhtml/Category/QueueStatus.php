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

namespace Mirasvit\DynamicCategory\Block\Adminhtml\Category;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;

class QueueStatus extends Template
{
    private $categoryRepository;

    private $dynamicCategoryRepository;

    private $messageManager;

    private $registry;

    public function __construct(
        CategoryRepository $categoryRepository,
        DynamicCategoryRepository $dynamicCategoryRepository,
        Registry $registry,
        MessageManagerInterface $messageManager,
        Context $context,
        array $data = []
    ) {
        $this->categoryRepository        = $categoryRepository;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;

        $this->messageManager = $messageManager;
        $this->registry       = $registry;

        parent::__construct($context, $data);
    }

    public function isRequireReindex()
    {
        $category = $this->registry->getCurrentCategory();

        if ($category->getId()) {
            $dynamicCategory = $this->dynamicCategoryRepository->getByCategoryId((int)$category->getId());
            if ($dynamicCategory && $dynamicCategory->getQueued()) {
                return true;
            }
        }

        return false;
    }

    public function getForceLink()
    {
        $category = $this->registry->getCurrentCategory();

        if (!$category->getId()) {
            return '';
        }

        return $this->getForceUrl(['id' => $category->getId()]);
    }

    public function getCategoryList()
    {
        $category = $this->registry->getCurrentCategory();

        if (!$category->getId()) {
            return [];
        }

        $collection = $this->dynamicCategoryRepository->getCollection();
        $collection->addFieldToFilter(DynamicCategoryInterface::QUEUED, true);


        $list = [];
        /** @var DynamicCategoryInterface $item */
        foreach ($collection as $item) {
            try {
                $categoryToReindex = $this->categoryRepository->get((int)$item->getCategoryId());
            } catch (\Exception $e) {
                continue;
            }
            $list[] = [
                'name' => $categoryToReindex->getName(),
                'link' => $this->getForceUrl(['id' => $categoryToReindex->getId()]),
            ];
        }

        return $list;
    }

    private function getForceUrl(array $args = []): string
    {
        $params = array_merge($this->getDefaultUrlParams(), $args);

        return $this->getUrl('mst_dynamic_category/category/force', $params);
    }

    /**
     * @return array
     */
    protected function getDefaultUrlParams()
    {
        return ['_current' => true, '_query' => ['isAjax' => null]];
    }
}
