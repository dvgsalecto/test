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

namespace Mirasvit\Brand\Model\Brand\PostData;

use Mirasvit\Brand\Api\Data\BrandPageStoreInterface;
use Mirasvit\Brand\Api\Data\PostData\ProcessorInterface;

class StoresProcessor implements ProcessorInterface
{
    public function preparePostData(array $data): array
    {
        if (isset($data['use_config']['stores']) && $data['use_config']['stores'] == 'true') {
            $data['stores'] = [0];
        } elseif (isset($data[BrandPageStoreInterface::STORE_ID])) {
            $data['stores'] = $data[BrandPageStoreInterface::STORE_ID];
        }

        return $data;
    }
}
