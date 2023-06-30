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


namespace Mirasvit\SeoAi\Service\Context;


use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\SeoAi\Model\ConfigProvider;

class BlogPostContext extends AbstractContext
{
    public function getContext(int $entityId = null, array $params = null): array
    {
        $context = parent::getContext($entityId, $params);

        if ($this->moduleManager->isEnabled('Mirasvit_BlogMx')) {
            $context['blog_post'] = $this->getMirasvitBlogPostContext($entityId);
        }

        return $context;
    }

    private function getMirasvitBlogPostContext(int $entityId): array
    {
        $data = [];

        $repository = $this->objectManager->get('Mirasvit\BlogMx\Repository\PostRepository');
        $post       = $repository->get($entityId);

        $data = [
            [
                'id'    => 'post.title',
                'label' => 'Title',
                'value' => $this->stripTags($category->getName()),
            ],
            [
                'id'    => 'post.content',
                'label' => 'Content',
                'value' => $this->stripTags($post->getContent()),
            ],
        ];

        return $data;
    }
}
