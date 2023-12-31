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



declare(strict_types=1);

namespace Mirasvit\DynamicCategory\Model\DynamicCategory\Condition\SmartCondition;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Model\AbstractModel;
use Magento\Rule\Model\Condition\Context;
use Mirasvit\DynamicCategory\Model\DynamicCategory\Condition\QueryBuilder;

class ReviewCondition extends AbstractCondition
{
    private $queryBuilder;

    public function __construct(
        QueryBuilder $queryBuilder,
        Context $context,
        array $data = []
    ) {
        $this->queryBuilder = $queryBuilder;

        parent::__construct($context, $data);
    }

    public function getAttributeElementHtml(): string
    {
        return (string)__('Number of reviews');
    }

    public function getInputType(): string
    {
        return 'numeric';
    }

    public function getValueElementType(): string
    {
        return 'text';
    }

    public function collectValidatedAttributes(Collection $collection): self
    {
        if ($this->queryBuilder->isJoined($collection->getSelect(), 'review_entity_summary')) {
            return $this;
        }

        $collection->getSelect()->joinLeft(
            [
                'review_summary' => $this->queryBuilder->getResource()->getTableName('review_entity_summary'),
            ],
            'review_summary.entity_pk_value = e.entity_id AND review_summary.store_id = 0',
            ['reviews_count']
        );

        return $this;
    }

    public function validate(AbstractModel $model): bool
    {
        $reviewsCount = (int)$model->getData('reviews_count');

        return $this->validateAttribute($reviewsCount);
    }
}
