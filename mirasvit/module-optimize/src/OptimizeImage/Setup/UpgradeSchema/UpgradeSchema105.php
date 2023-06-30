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
 * @package   mirasvit/module-optimize
 * @version   1.3.20
 * @copyright Copyright (C) 2022 Mirasvit (https://mirasvit.com/)
 */




namespace Mirasvit\OptimizeImage\Setup\UpgradeSchema;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Mirasvit\OptimizeImage\Api\Data\FileInterface;

class UpgradeSchema105 implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();

        $connection->dropIndex(
            $setup->getTable(FileInterface::TABLE_NAME),
            $setup->getIdxName(
                FileInterface::TABLE_NAME,
                [FileInterface::COMPRESSION]
            )
        );

        $connection->addIndex(
            $setup->getTable(FileInterface::TABLE_NAME),
            $setup->getIdxName(
                FileInterface::TABLE_NAME,
                [FileInterface::ACTUAL_SIZE, FileInterface::PROCESSED_AT, FileInterface::COMPRESSION]
            ),
            [FileInterface::ACTUAL_SIZE, FileInterface::PROCESSED_AT, FileInterface::COMPRESSION]
        );
    }
}
