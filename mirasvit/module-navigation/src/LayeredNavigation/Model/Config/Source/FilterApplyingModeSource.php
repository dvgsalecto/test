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
 * @version   2.2.32
 * @copyright Copyright (C) 2022 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\LayeredNavigation\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class FilterApplyingModeSource implements OptionSourceInterface
{
    const OPTION_INSTANTLY       = 'instantly';
    const OPTION_BY_BUTTON_CLICK = 'by_button_click';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::OPTION_INSTANTLY, 'label' => __('Instantly')],
            ['value' => self::OPTION_BY_BUTTON_CLICK, 'label' => __('By button click')],
        ];
    }
}
