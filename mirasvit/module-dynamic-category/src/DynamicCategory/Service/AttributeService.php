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
 * @version   1.2.24
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);

namespace Mirasvit\DynamicCategory\Service;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AttributeService
{
    const ENTITY_TYPE = 'catalog_product';

    private $entityTypeId = 0;

    private $attributeTables = [];

    private $collectionFactory;

    private $connection;

    private $resource;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ResourceConnection $resource
    ) {
        $this->collectionFactory = $collectionFactory;

        $this->resource   = $resource;
        $this->connection = $resource->getConnection();
    }

    public function getAttributeValues(string $name, array $storeIds, array $productIds): array
    {
        $excluded = ['attribute_set_id', 'type_id', 'sku', 'category_ids'];
        if (in_array($name, $excluded)) {
            return [];
        }

        $info = $this->getAttributeInfo($name);

        $idField = 'entity_id';
        if (!$this->resource->getConnection()->tableColumnExists($this->resource->getTableName($info['table']), 'entity_id')) {
            $idField = 'row_id';
        }

        $query = $this->resource->getConnection()
            ->select()
            ->from(['ev' => $this->resource->getTableName($info['table'])], [$idField, 'value'])
            ->where('ev.attribute_id = ?', $info['id'])
            ->where('ev.store_id IN(?)', $storeIds)
            ->where('ev.' . $idField . ' IN(?)', $productIds)
            ->order('ev.store_id')
            ->group('ev.' . $idField);

        $rows = $this->resource->getConnection()->fetchAll($query);

        $data = [];
        foreach ($rows as $row) {
            $data[$row[$idField]] = $row['value'];
        }

        return $data;
    }

    public function getAttributeInfo(string $name): array
    {
        if (!isset($this->attributeTables[$name])) {
            $typeId = $this->getProductEntityTypeId();

            $mainTable = 'catalog_product_entity_';

            $query = $this->connection
                ->select()
                ->from(['ev' => $this->resource->getTableName('eav_attribute')], ['attribute_id', 'backend_type'])
                ->where('ev.entity_type_id = ?', $typeId)
                ->where('ev.attribute_code = ?', $name);

            $row = $this->resource->getConnection()->fetchRow($query);

            if ($row['backend_type'] == 'static') {
                $product = $this->collectionFactory->create();

                $this->attributeTables[$name] = $product->getEntity()->getAttribute($name)->getBackend()->getTable();
                $this->attributeTables[$name] = [
                    'id'    => $row['attribute_id'],
                    'table' => $product->getEntity()->getAttribute($name)->getBackend()->getTable(),
                ];;
            } else {
                $this->attributeTables[$name] = [
                    'id'    => $row['attribute_id'],
                    'table' => $mainTable . $row['backend_type'],
                ];
            }
        }

        return $this->attributeTables[$name];
    }

    public function getProductEntityTypeId(): int
    {
        if (!$this->entityTypeId) {
            $query = $this->connection
                ->select()
                ->from(['ev' => $this->resource->getTableName('eav_entity_type')], ['entity_type_id'])
                ->where('ev.entity_type_code = ?', self::ENTITY_TYPE);

            $this->entityTypeId = (int)$this->resource->getConnection()->fetchOne($query);
        }

        return $this->entityTypeId;
    }
}
