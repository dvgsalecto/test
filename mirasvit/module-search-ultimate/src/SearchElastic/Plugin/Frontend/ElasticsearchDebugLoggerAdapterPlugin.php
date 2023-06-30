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
 * @version   2.0.97
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\SearchElastic\Plugin\Frontend;

use Magento\Elasticsearch\SearchAdapter\ConnectionManager;
use Magento\Elasticsearch7\SearchAdapter\Mapper;
use Magento\Framework\Search\AdapterInterface;
use Magento\Framework\Search\RequestInterface;
use Magento\Framework\Search\Response\QueryResponse;
use Mirasvit\Search\Service\DebugService;

/**
 * @see \Magento\Elasticsearch7\SearchAdapter\Adapter::query()
 */
class ElasticsearchDebugLoggerAdapterPlugin
{
    private $mapper;

    private $connectionManager;

    private $debugService;

    public function __construct(
        Mapper            $mapper,
        ConnectionManager $connectionManager,
        DebugService      $debugService
    ) {
        $this->mapper            = $mapper;
        $this->connectionManager = $connectionManager;
        $this->debugService      = $debugService;
    }

    public function aroundQuery(AdapterInterface $subject, callable $proceed, RequestInterface $request): QueryResponse
    {
        if ($this->debugService->isEnabled()) {
            $client = $this->connectionManager->getConnection();
            /** @var \Magento\Elasticsearch7\Model\Client\Elasticsearch $client */
            $query = $this->mapper->buildQuery($request);

            $indexName = $request->getName();

            DebugService::log(\Zend_Json::encode($query), 'query: ' . $indexName);

            try {
                $rawResponse = $client->query($query);
            } catch (\Exception $e) {
                DebugService::log($e->getMessage(), 'exception: ' . $indexName);
                $rawResponse = [];
            }

            DebugService::log(\Zend_Json::encode($rawResponse), 'response: ' . $indexName);
        }

        return $proceed($request);
    }
}
