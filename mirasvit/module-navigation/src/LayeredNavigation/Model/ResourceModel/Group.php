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
 * @package   mirasvit/module-navigation
 * @version   2.6.0
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);


namespace Mirasvit\LayeredNavigation\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Mirasvit\LayeredNavigation\Api\Data\GroupInterface;

class Group extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init(GroupInterface::TABLE_NAME, GroupInterface::ID);
    }
}