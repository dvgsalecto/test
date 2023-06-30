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


namespace Mirasvit\DynamicCategory\Setup\Patch\Data;

use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;
use Magento\Framework\App\State;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\DynamicCategory\Repository\DynamicCategoryRepository;
use Mirasvit\DynamicCategory\Service\CategoryService;

/**
 * Class DataPatch001002019 = the name of the class is version with leading 0, in this case 1.2.19
 */
class DataPatch001002019 implements DataPatchInterface
{
    private $appState;

    private $categoryService;

    private $dynamicCategoryRepository;

    private $productResource;

    private $setup;

    public function __construct(
        State $appState,
        CategoryService $categoryService,
        DynamicCategoryRepository $dynamicCategoryRepository,
        ResourceProduct $productResource,
        ModuleDataSetupInterface $setup
    ) {
        $this->appState = $appState;

        $this->categoryService = $categoryService;

        $this->dynamicCategoryRepository = $dynamicCategoryRepository;

        $this->productResource = $productResource;

        $this->setup = $setup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->setup->getConnection()->startSetup();

        $this->resaveCategories();

        $this->setup->getConnection()->endSetup();
    }

    /**
     * @return void
     */
    private function resaveCategories()
    {
        try {
            $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        } catch (\Exception $e) {}

        $collection = $this->dynamicCategoryRepository->getCollection();

        foreach ($collection as $dynamicCategory) {
            $conditionData = $dynamicCategory->getRule()->getConditions()->asArray();
            $attr = [];

            if ($conditionData && isset($conditionData['conditions'])) {
                $this->parseConditions($conditionData['conditions'], $attr);

                $conditions = (string)SerializeService::encode($conditionData);

                $dynamicCategory->setAttributes($attr);
                $dynamicCategory->setConditionsSerialized($conditions);

                $this->dynamicCategoryRepository->save($dynamicCategory);
            }
        }
    }

    private function parseConditions(&$conditions, &$attrs)
    {
        $productAttributes = $this->productResource->loadAllAttributes()->getAttributesByCode();

        foreach ($conditions as $k => $cond) {
            if (!empty($cond['conditions'])) {
                $this->parseConditions($cond['conditions'], $attrs);
            } elseif (strpos($cond['type'], 'ProductCondition') && !empty($cond['attribute'])) {
                foreach ($productAttributes as $attribute) {
                    /* @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
                    if ($cond['attribute'] == $attribute->getAttributeCode() &&
                        $attribute->getFrontendInput() == 'multiselect'
                    ) {
                        $conditions[$k]['is_multiselect'] = true;
                    }
                }

                $attrs[] = $cond['attribute'];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}