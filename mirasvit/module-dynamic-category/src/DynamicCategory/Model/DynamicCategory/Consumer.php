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

namespace Mirasvit\DynamicCategory\Model\DynamicCategory;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Notification\NotifierInterface;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryQueueInterface;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;
use Mirasvit\DynamicCategory\Service\ReindexService;

class Consumer
{
    private $dynamicCategoryRepository;

    private $logger;

    private $notifier;

    private $reindexService;

    public function __construct(
        DynamicCategoryRepository $dynamicCategoryRepository,
        ReindexService $reindexService,
        \Psr\Log\LoggerInterface $logger,
        NotifierInterface $notifier
    ) {
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
        $this->logger         = $logger;
        $this->notifier       = $notifier;
        $this->reindexService = $reindexService;
    }

    /**
     * @param DynamicCategoryQueueInterface $queueCategory
     * @return void
     */
    public function process(DynamicCategoryQueueInterface $queueCategory)
    {
        try {
            $dynamicCategory = $this->dynamicCategoryRepository->get($queueCategory->getId());

            $this->reindexService->reindexCategory($dynamicCategory);

            $dynamicCategory->setQueued(false);

            $this->dynamicCategoryRepository->save($dynamicCategory);

            $this->notifier->addMajor(
                __('Dynamic category index completed.'),
                __('Dynamic category index completed')
            );
        } catch (LocalizedException $e) {
            $this->notifier->addCritical(
                __('Error during dynamic category index'),
                __('Error during dynamic category index. Please check logs for detail')
            );
            $this->logger->critical(
                'Something went wrong while dynamic category index process. ' . $e->getMessage()
            );
        }
    }
}
