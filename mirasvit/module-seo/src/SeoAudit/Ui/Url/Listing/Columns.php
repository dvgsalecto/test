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
 * @package   mirasvit/module-seo
 * @version   2.6.8
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);


namespace Mirasvit\SeoAudit\Ui\Url\Listing;


use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Mirasvit\SeoAudit\Api\Data\CheckResultInterface;
use Mirasvit\SeoAudit\Api\Data\UrlInterface;
use Mirasvit\SeoAudit\Repository\CheckResultRepository;

class Columns extends \Magento\Ui\Component\Listing\Columns
{
    private $checkResultRepository;

    private $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager,
        CheckResultRepository  $checkResultRepository,
        ContextInterface       $context,
        array                  $components = [],
        array                  $data = []
    ) {
        $this->checkResultRepository = $checkResultRepository;
        $this->objectManager         = $objectManager;

        parent::__construct($context, $components, $data);
    }

    public function prepare()
    {
        $identifier = $this->context->getRequestParam(CheckResultInterface::IDENTIFIER);
        $issueType  = $this->context->getRequestParam(CheckResultInterface::RESULT);

        $columns = [
            UrlInterface::URL => [
                'label'    => (string)__('URL'),
                'bodyTmpl' => 'ui/grid/cells/html',
                'sortable' => true,
                'visible'  => true,
                'filter'   => 'text',
            ],
        ];

        if ($identifier) {
            $checkInstance = $this->checkResultRepository->getCheckInstanceByIdentifier($identifier);

            $columns[CheckResultInterface::RESULT] = [
                'label'      => (string)__('Score'),
                'bodyTmpl'   => 'ui/grid/cells/html',
                'fieldClass' => 'mst_seo_audit',
                'sortable'   => true,
                'sorting'    => 'asc',
                'visible'    => true,
            ];
            $columns[CheckResultInterface::MESSAGE]  = [
                'label'      => (string)__('Message'),
                'fieldClass' => 'mst_seo_audit',
                'bodyTmpl'   => 'ui/grid/cells/html',
                'sortable'   => false,
                'visible'    => true,
            ];
            $columns[CheckResultInterface::VALUE]  = [
                'label'      => $checkInstance->getGridColumnLabel(),
                'fieldClass' => $checkInstance->getGridFieldClass(),
                'bodyTmpl'   => 'ui/grid/cells/html',
                'sortable'   => false,
                'visible'    => true,
            ];

        } elseif ($issueType) {
            $columns['checks'] = [
                'label'      => (string)__('Checks'),
                'bodyTmpl'   => 'ui/grid/cells/html',
                'fieldClass' => 'mst_seo_audit',
                'sortable'   => false,
                'visible'    => true,
            ];
        }

        $sortOrder = 100;
        foreach ($columns as &$column) {
            if (!isset($column['visible'])) {
                $column['visible'] = false;
            }

            $column['sortOrder'] = $sortOrder;

            $sortOrder += 10;
        }

        $this->addColumns($columns);

        parent::prepare(); // TODO: Change the autogenerated stub
    }

    private function addColumns(array $columns): void
    {
        foreach ($columns as $identifier => $config) {
            $arguments                   = [
                'data'    => [
                    'name'   => $identifier,
                    'config' => [
                        'dataType'  => 'text',
                        'fieldName' => $identifier,
                        'component' => 'Magento_Ui/js/grid/columns/column',
                    ],
                ],
                'context' => $this->context,
            ];
            $arguments['data']['config'] = array_merge($arguments['data']['config'], $config);

            if (isset($arguments['data']['config']['options'])) {
                $arguments['data']['config']['options'] = $this->objectManager->create(
                    $arguments['data']['config']['options']
                )->toOptionArray();
            }

            $column = isset($arguments['data']['config']['class'])
                ? $this->objectManager->create($arguments['data']['config']['class'], $arguments)
                : $this->context->getUiComponentFactory()->create($identifier, 'column', $arguments);

            $column->prepare();

            $this->addComponent($identifier, $column);
        }
    }
}
