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

namespace Mirasvit\DynamicCategory\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;
use Mirasvit\DynamicCategory\Service\ReindexService;

class Force extends Action implements HttpGetActionInterface
{
    private $dynamicCategoryRepository;

    private $reindexService;

    public function __construct(
        DynamicCategoryRepository $dynamicCategoryRepository,
        ReindexService $reindexService,
        Action\Context $context
    ) {
        parent::__construct($context);

        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
        $this->reindexService            = $reindexService;
    }

    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('id');

        $dynamicCategory = $this->dynamicCategoryRepository->getByCategoryId($id);

        if (!$dynamicCategory) {
            return $resultRedirect->setPath('catalog/category/', ['_current' => true, 'id' => $id]);
        }

        $this->reindexService->reindexCategory($dynamicCategory);

        $this->messageManager->addSuccessMessage(__('Category was reindexed.'));

        return $resultRedirect->setPath('catalog/category/', ['_current' => true, 'id' => $id]);
    }
}
