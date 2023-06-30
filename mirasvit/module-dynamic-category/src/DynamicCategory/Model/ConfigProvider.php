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



namespace Mirasvit\DynamicCategory\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    const REINDEX_MODE_ON_SAVE     = 'on_save';
    const REINDEX_MODE_BY_SCHEDULE = 'by_schedule';

    const EXCLUDED_PRODUCT_VISIBILITY_NONE      = 'none';
    const EXCLUDED_PRODUCT_VISIBILITY_INVISIBLE = 'invisible';

    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getIntegrateWithReindex()
    {
        return $this->scopeConfig->getValue('dynamic_category/general/integrate_with_reindex');
    }

    /**
     * @return string
     */
    public function getExcludedProductVisibility()
    {
        return $this->scopeConfig->getValue('dynamic_category/general/excluded_product_visibility');
    }
}
