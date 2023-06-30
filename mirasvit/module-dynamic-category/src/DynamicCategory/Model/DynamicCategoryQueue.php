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

namespace Mirasvit\DynamicCategory\Model;

use Magento\Framework\DataObject;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryQueueInterface;

class DynamicCategoryQueue extends DataObject implements DynamicCategoryQueueInterface
{
    public function getId(): int
    {
        return (int)$this->getData(DynamicCategoryInterface::ID);
    }

    public function setId(int $id): DynamicCategoryQueueInterface
    {
        return $this->setData(DynamicCategoryInterface::ID, $id);
    }

    public function getCategoryId(): int
    {
        return (int)$this->getData(DynamicCategoryInterface::CATEGORY_ID);
    }

    public function setCategoryId(int $id): DynamicCategoryQueueInterface
    {
        return $this->setData(DynamicCategoryInterface::CATEGORY_ID, $id);
    }
}
