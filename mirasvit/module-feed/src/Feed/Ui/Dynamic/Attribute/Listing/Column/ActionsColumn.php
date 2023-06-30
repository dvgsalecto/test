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
 * @package   mirasvit/module-feed
 * @version   1.2.9
 * @copyright Copyright (C) 2022 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\Feed\Ui\Dynamic\Attribute\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Mirasvit\FormBuilder\Api\Data\FormInterface;

class ActionsColumn extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = [
                    'edit'      => [
                        'href'  => $this->context->getUrl('mst_feed/dynamic_attribute/edit', [
                            'id' => $item['attribute_id'],
                        ]),
                        'label' => __('Edit'),
                    ],
                    'delete'    => [
                        'href'    => $this->context->getUrl('mst_feed/dynamic_attribute/delete', [
                            'id' => $item['attribute_id'],
                        ]),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __("Delete {$item['name']}"),
                            'message' => __("Are you sure you wan't to delete a dynamic attribute '{$item['name']}'?"),
                        ],
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
