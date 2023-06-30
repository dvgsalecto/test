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

namespace Mirasvit\DynamicCategory\Plugin;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Mview\View\ChangelogInterface;
use Magento\Catalog\Model\Indexer\Category\Product\Action\Full;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Model\ConfigProvider;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;
use Mirasvit\DynamicCategory\Service\ReindexService;

/**
 * @see Full::execute()
 */
class FullReindexDynamicCategoryPlugin
{
    private $changelog;

    private $configProvider;

    private $dynamicCategoryRepository;

    private $reindexService;

    private $resource;

    public function __construct(
        ChangelogInterface $changelog,
        ConfigProvider $configProvider,
        DynamicCategoryRepository $dynamicCategoryRepository,
        ReindexService $reindexService,
        ResourceConnection $resource
    ) {
        $this->changelog      = $changelog;
        $this->configProvider = $configProvider;

        $this->dynamicCategoryRepository = $dynamicCategoryRepository;

        $this->reindexService = $reindexService;

        $this->resource = $resource;
    }

    /**
     * @param Full $subject
     *
     * @return null
     */
    public function beforeExecute(Full $subject)
    {
        if (!$this->configProvider->getIntegrateWithReindex()) {
            return null;
        }

        $collection = $this->dynamicCategoryRepository->getCollection()
            ->addFieldToFilter(DynamicCategoryInterface::IS_ACTIVE, 1);

        /** @var DynamicCategoryInterface $dynamicCategory */
        foreach ($collection as $dynamicCategory) {
            $this->reindexService->reindexCategory($dynamicCategory);
        }

        return null;
    }

    /**
     * @param Full $subject
     *
     * @return null
     */
    public function afterExecute(Full $subject, $result)
    {
        if (!$this->configProvider->getIntegrateWithReindex()) {
            return $result;
        }

        $indexes = [
            'catalog_product_category',
            'catalogrule_product',
        ];

        foreach ($indexes as $index) {
            $this->changelog->setViewId($index);

            $changelogTableName = $this->resource->getTableName($this->changelog->getName());
            if ($this->resource->getConnection()->isTableExists($changelogTableName)) {
                $versionId = $this->changelog->getVersion();

                $this->changelog->clear($versionId + 1);
            }
        }

        return $result;
    }
}
