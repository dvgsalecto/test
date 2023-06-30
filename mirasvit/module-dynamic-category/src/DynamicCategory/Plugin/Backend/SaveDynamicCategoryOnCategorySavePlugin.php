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

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Indexer\Category\Product;
use Magento\Catalog\Model\ResourceModel\Category as ResourceCategory;
use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogSearch\Model\Indexer\Fulltext as FulltextIndexer;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Model\AbstractModel;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Registry;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Model\DynamicCategory;
use Mirasvit\DynamicCategory\Model\DynamicCategoryQueueFactory;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;
use Mirasvit\DynamicCategory\Service\CategoryService;
use Mirasvit\DynamicCategory\Service\ReindexService;

/**
 * @see \Magento\Catalog\Model\ResourceModel\Category::_afterSave
 * @see \Magento\Catalog\Model\ResourceModel\Category::_saveCategoryProducts
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SaveDynamicCategoryOnCategorySavePlugin
{
    private $categoryService;

    private $collectionFactory;

    private $configProvider;

    private $dynamicCategoryQueueFactory;

    private $dynamicCategoryRepository;

    private $indexerRegistry;

    private $messageManager;

    private $productMetadata;

    private $productResource;

    private $registry;

    private $reindexService;

    private $messagePublisher;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        CategoryService $categoryService,
        CollectionFactory $collectionFactory,
        ConfigProvider $configProvider,
        DynamicCategoryQueueFactory $dynamicCategoryQueueFactory,
        DynamicCategoryRepository $dynamicCategoryRepository,
        IndexerRegistry $indexerRegistry,
        ManagerInterface $messageManager,
        ProductMetadataInterface $productMetadata,
        ResourceProduct $productResource,
        Registry $registry,
        ReindexService $reindexService,
        PublisherInterface $publisher
    ) {
        $this->categoryService           = $categoryService;
        $this->collectionFactory         = $collectionFactory;
        $this->configProvider            = $configProvider;
        $this->dynamicCategoryQueueFactory = $dynamicCategoryQueueFactory;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
        $this->indexerRegistry           = $indexerRegistry;
        $this->messageManager            = $messageManager;
        $this->messagePublisher          = $publisher;
        $this->productMetadata           = $productMetadata;
        $this->productResource           = $productResource;
        $this->registry                  = $registry;
        $this->reindexService            = $reindexService;

    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function aroundSave(ResourceCategory $subject, callable $proceed, AbstractModel $category): ResourceCategory
    {
        /** @var Category $category */
        if (!$category->hasData(AddDynamicCategoryDataPlugin::FIELD_IS_DYNAMIC_CATEGORY) ||
            $this->registry->isReindexCategory()
        ) {
            return $proceed($category);
        }

        $id         = (int)$category->getId();
        $isActive   = (bool)$category->getData(AddDynamicCategoryDataPlugin::FIELD_IS_DYNAMIC_CATEGORY);
        $reindexNow = (bool)$category->getData(DynamicCategoryInterface::REINDEX_NOW);
        $ruleData   = $category->getData('rule');

        $dynamicCategory = $this->getDynamicCategory($id);

        $dynamicCategory->setCategoryId($id);
        $dynamicCategory->setIsActive($isActive);
        $dynamicCategory->setReindexNow($reindexNow);

        if ($isActive) {
            $rule = $dynamicCategory->getRule();

            if ($ruleData) {
                $ruleData = $this->categoryService->prepareConditions($ruleData);

                $productAttributes = $this->productResource->loadAllAttributes()->getAttributesByCode();

                $attrs = [];
                foreach ($ruleData['conditions'] as $k => $cond) {
                    if (strpos($cond['type'], 'ProductCondition') && !empty($cond['attribute'])) {
                        foreach ($productAttributes as $attribute) {
                            /* @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
                            if ($cond['attribute'] == $attribute->getAttributeCode() && $attribute->getFrontendInput() == 'multiselect') {
                                $ruleData['conditions'][$k]['is_multiselect'] = true;
                            }
                        }

                        $attrs[] = $cond['attribute'];
                    }
                }

                $attrs = array_unique($attrs);

                $conditions = $rule->loadPost($ruleData)->getConditions()->asArray();
                $conditions = (string)SerializeService::encode($conditions);

                $dynamicCategory->setAttributes($attrs);
                $dynamicCategory->setConditionsSerialized($conditions);
            }
        } else {
            if ($dynamicCategory->getId()) {
                $this->dynamicCategoryRepository->delete($dynamicCategory);
            }
        }

        $return = $proceed($category);

        if (!$category->getId()) {
            return $return;
        }

        if ($isActive) {
            $dynamicCategory->setCategoryId((int)$category->getId());
            $dynamicCategory->setQueued(true);

            $this->dynamicCategoryRepository->save($dynamicCategory);

            $queueCategory = $this->dynamicCategoryQueueFactory->create();
            $queueCategory->setId($dynamicCategory->getId());
            $queueCategory->setCategoryId($dynamicCategory->getCategoryId());

            $this->messagePublisher->publish('mst_dynamic_category.index', $queueCategory);
        }

        return $return;
    }

    public function reindex()
    {
        if ($this->registry->getReindexCategory()) {
            $category       = $this->registry->getReindexCategory();
            $productIndexer = $this->indexerRegistry->get(Product::INDEXER_ID);
            $productIndexer->reindexList($category->getPathIds());
            if (version_compare($this->productMetadata->getVersion(), "2.4.2", ">=")) {
                $affectedProducts = $category->getAffectedProductIds();
                if (is_array($affectedProducts)) {
                    $indexer = $this->indexerRegistry->get(FulltextIndexer::INDEXER_ID);
                    $indexer->reindexList($affectedProducts);
                }
            }
        }
        $this->registry->setReindexCategory(null);
    }


    private function getDynamicCategory(int $id): DynamicCategory
    {
        if (!$id) {
            $dynamicCategory = $this->dynamicCategoryRepository->create();
        } else {
            $dynamicCategory = $this->dynamicCategoryRepository->getByCategoryId($id);

            if (!$dynamicCategory) {
                $dynamicCategory = $this->dynamicCategoryRepository->create();
            }
        }

        return $dynamicCategory;
    }

}
