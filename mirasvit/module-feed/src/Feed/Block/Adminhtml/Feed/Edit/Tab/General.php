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



namespace Mirasvit\Feed\Block\Adminhtml\Feed\Edit\Tab;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store as SystemStore;
use Mirasvit\Feed\Model\Config;
use Mirasvit\Feed\Model\Config\Source\Type as SourceType;

class General extends Form
{
    protected $sourceType;

    protected $systemStore;

    protected $formFactory;

    protected $registry;

    protected $context;

    protected $config;

    public function __construct(
        Config $config,
        SourceType $sourceType,
        SystemStore $systemStore,
        FormFactory $formFactory,
        Registry $registry,
        Context $context
    ) {
        $this->sourceType  = $sourceType;
        $this->systemStore = $systemStore;
        $this->formFactory = $formFactory;
        $this->registry    = $registry;
        $this->context     = $context;
        $this->config      = $config;

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareForm()
    {
        /** @var \Mirasvit\Feed\Model\Feed $model */
        $model = $this->registry->registry('current_model');
        $form = $this->formFactory->create();
        $form->setFieldNameSuffix('feed');
        $this->setForm($form);

        $general = $form->addFieldset('general', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $general->addField('feed_id', 'hidden', [
                'name'  => 'feed_id',
                'value' => $model->getId(),
            ]);
        }

        $general->addField('name', 'text', [
            'label'    => __('Name'),
            'required' => true,
            'name'     => 'name',
            'value'    => $model->getData('name')
        ]);

        $general->addField('filename', 'text', [
            'label'    => __('Filename'),
            'required' => true,
            'name'     => 'filename',
            'value'    => $model->getData('filename')
        ]);

        $general->addField('type', 'select', [
            'label'    => __('File Type'),
            'required' => true,
            'name'     => 'type',
            'value'    => $model->getData('type'),
            'values'   => $this->sourceType->toOptionArray(),
            'onchange' => 'feedMapping.changeFormat(this);',
            'disabled' => $model->getName() ? true : false,
        ]);

        if (!$this->context->getStoreManager()->isSingleStoreMode()) {
            $general->addField('store_id', 'select', [
                'label'    => __('Store View'),
                'required' => true,
                'name'     => 'store_id',
                'value'    => $model->getData('store_id'),
                'values'   => $this->systemStore->getStoreValuesForForm(),
            ]);
        } else {
            $general->addField('store_id', 'hidden', [
                'name'  => 'store_id',
                'value' => $this->context->getStoreManager()->getStore(true)->getId(),
            ]);
        }

        $general->addField('is_active', 'select', [
            'label'    => __('Is Active'),
            'required' => true,
            'name'     => 'is_active',
            'value'    => $model->getData('is_active'),
            'values'   => [0 => __('No'), 1 => __('Yes')],
        ]);

        if ($model->getUrl()) {
            $general->addField('generation_info', 'note', [
                'text' => $this->getLayout()->createBlock('\Mirasvit\Feed\Block\Adminhtml\Feed\Edit\Tab\General\Info')
                    ->toHtml(),
            ]);

            if ($this->config->isReportsEnabled()) {
                $general->addField('statistics', 'note', [
                    'label' => __('Statistics'),
                    'text' => $this->getLayout()->createBlock('\Mirasvit\Feed\Block\Adminhtml\Feed\Edit\Tab\General\Statistics')
                        ->toHtml(),
                ]);
            }
        }

        return parent::_prepareForm();
    }
}
