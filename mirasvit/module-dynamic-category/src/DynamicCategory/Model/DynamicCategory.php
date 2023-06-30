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

namespace Mirasvit\DynamicCategory\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\DynamicCategory\Api\Data\DynamicCategoryInterface;
use Mirasvit\DynamicCategory\Model\ResourceModel\DynamicCategory as DynamicCategoryResource;
use Mirasvit\DynamicCategory\Model\DynamicCategory\Rule;
use Mirasvit\DynamicCategory\Model\DynamicCategory\RuleFactory;

class DynamicCategory extends AbstractModel implements DynamicCategoryInterface
{
    /**
     * @var Rule|null
     */
    private $rule = null;

    private $ruleFactory;

    public function __construct(
        RuleFactory $ruleFactory,
        Context $context,
        Registry $registry
    ) {
        $this->ruleFactory = $ruleFactory;

        parent::__construct($context, $registry);
    }

    protected function _construct()
    {
        $this->_init(DynamicCategoryResource::class);
    }

    public function getId(): int
    {
        return (int)$this->getData(DynamicCategoryInterface::ID);
    }

    public function getCategoryId(): int
    {
        return (int)$this->getData(DynamicCategoryInterface::CATEGORY_ID);
    }

    public function setCategoryId(int $id): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::CATEGORY_ID, $id);
    }

    public function getConditionsSerialized(): string
    {
        return (string)$this->getData(DynamicCategoryInterface::CONDITIONS_SERIALIZED);
    }

    public function setConditionsSerialized(string $conditions): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::CONDITIONS_SERIALIZED, $conditions);
    }

    public function getAttributes(): array
    {
        if ($this->getData(DynamicCategoryInterface::ATTRIBUTES)) {
            return (array)SerializeService::decode($this->getData(DynamicCategoryInterface::ATTRIBUTES));
        }

        return [];
    }

    public function setAttributes(array $attributes): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::ATTRIBUTES, SerializeService::encode($attributes));
    }

    public function getIsActive(): bool
    {
        return (bool)$this->getData(DynamicCategoryInterface::IS_ACTIVE);
    }

    public function setIsActive(bool $flag): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::IS_ACTIVE, $flag);
    }

    public function getReindexNow(): bool
    {
        return (bool)$this->getData(DynamicCategoryInterface::REINDEX_NOW);
    }

    public function setReindexNow(bool $flag): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::REINDEX_NOW, $flag);
    }

    public function getQueued(): bool
    {
        return (bool)$this->getData(DynamicCategoryInterface::QUEUED);
    }

    public function setQueued(bool $flag): DynamicCategoryInterface
    {
        return $this->setData(DynamicCategoryInterface::QUEUED, $flag);
    }

    public function getRule(): \Mirasvit\DynamicCategory\Model\DynamicCategory\Rule
    {
        if (!$this->rule) {
            $this->rule = $this->ruleFactory->create()
                ->setData(self::CONDITIONS_SERIALIZED, $this->getData(self::CONDITIONS_SERIALIZED));
        }

        return $this->rule;
    }
}
