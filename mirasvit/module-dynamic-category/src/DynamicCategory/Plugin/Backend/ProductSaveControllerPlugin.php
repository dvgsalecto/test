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

namespace Mirasvit\DynamicCategory\Plugin\Backend;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Magento\Framework\App\ProductMetadataInterface;
use Mirasvit\DynamicCategory\Registry;

/**
 * @see Save::execute()
 */
class ProductSaveControllerPlugin
{
    private $productMetadata;

    private $registry;

    public function __construct(
        ProductMetadataInterface $productMetadata,
        Registry $registry
    ) {
        $this->productMetadata = $productMetadata;
        $this->registry        = $registry;
    }

    public function beforeExecute(Save $subject): ?Redirect
    {
        if (version_compare($this->productMetadata->getVersion(), "2.4.2", "<")) {
            return null;
        }

        $this->registry->setIsSavingProduct(true);

        return null;
    }

    public function afterExecute(Save $subject, Redirect $result): Redirect
    {
        if (version_compare($this->productMetadata->getVersion(), "2.4.2", "<")) {
            return $result;
        }

        $this->registry->setIsSavingProduct(false);

        return $result;
    }
}
