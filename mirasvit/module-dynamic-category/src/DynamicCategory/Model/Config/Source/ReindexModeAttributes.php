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



namespace Mirasvit\DynamicCategory\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Mirasvit\DynamicCategory\Model\ConfigProvider;

class ReindexModeAttributes implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => ConfigProvider::REINDEX_MODE_ON_SAVE, 'label' => __('On Save')],
            ['value' => ConfigProvider::REINDEX_MODE_BY_SCHEDULE, 'label' => __('By Schedule')],
        ];
    }
}
