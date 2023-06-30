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
 * @package   mirasvit/module-search-ultimate
 * @version   2.1.0
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\SearchMysql\SearchAdapter\Aggregation;

class DataProviderContainer
{
    private $dataProvider;

    public function __construct(array $dataProviders = [])
    {
        $this->dataProvider = $dataProviders;
    }

    public function get(string $indexName): DataProvider
    {
        return $this->dataProvider[$indexName];
    }
}
