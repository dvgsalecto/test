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

namespace Mirasvit\DynamicCategory\Api\Data;

interface DynamicCategoryQueueInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return DynamicCategoryQueueInterface
     */
    public function setId(int $id): self;

    /**
     * @return int
     */
    public function getCategoryId(): int;

    /**
     * @param int $id
     *
     * @return DynamicCategoryQueueInterface
     */
    public function setCategoryId(int $id): self;
}
