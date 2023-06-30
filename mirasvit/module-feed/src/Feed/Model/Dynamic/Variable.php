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



namespace Mirasvit\Feed\Model\Dynamic;

use Magento\Backend\Block\Template as BlockTemplate;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\TemplateEngine\Php as PhpEngine;
use Mirasvit\Feed\Model\Config;

/**
 * @method string getName()
 * @method string getCode()
 */
class Variable extends AbstractModel
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var PhpEngine
     */
    private $phpEngine;

    /**
     * @var BlockTemplate
     */
    private $blockTemplate;

    /**
     * Variable constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param Context                $context
     * @param Config                 $config
     * @param PhpEngine              $phpEngine
     * @param BlockTemplate          $blockTemplate
     * @param Registry               $registry
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        Context                $context,
        Config                 $config,
        PhpEngine              $phpEngine,
        BlockTemplate          $blockTemplate,
        Registry               $registry
    ) {
        $this->objectManager = $objectManager;
        $this->config        = $config;
        $this->phpEngine     = $phpEngine;
        $this->blockTemplate = $blockTemplate;

        parent::__construct($context, $registry);
    }

    /**
     * @param \Magento\Catalog\Model\Product                 $product
     * @param \Mirasvit\Feed\Export\Resolver\ProductResolver $resolver
     *
     * @return string
     * @SuppressWarnings(PHPMD)
     */
    public function getValue($product, $resolver)
    {
        if (!$this->getFilePath()) {
            return '';
        }

        $value   = '';
        $absPath = $this->config->getRootPath() . $this->getFilePath();

        if (!file_exists($absPath)) {
            return '';
        }

        $value = $this->phpEngine->render($this->blockTemplate, $absPath, ['product' => $product, 'objectManager' => $this->objectManager]);

        return $value;
    }

    public function getAbsFilePath()
    {
        return  $this->config->getRootPath() . $this->getFilePath();
    }

    public function getFilePath()
    {
        if (!$this->getCode()) {
            return '';
        }

        return 'app/code/Mirasvit/Feed/' . $this->getCode() . '.php';
    }

    public function getPhpCode()
    {
        if (!$this->getFilePath()) {
            return __('Please set "Variable Code" and save the variable before continuing...');
        }
        $filePath = $this->config->getRootPath() . $this->getFilePath();
        if (!file_exists($filePath)) {
            return __('Please create the file %1 with source code', $this->getFilePath());
        }
        if (is_readable($filePath)) {
            return file_get_contents($filePath);
        } else {
            return __('The file %1 is not readable', $this->getFilePath());
        }
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function isValid($code = null)
    {
        if (!$code) {
            $code = $this->getPhpCode();
        }

        $code = escapeshellarg('<?php ' . $code . ' ?>');
        $lint = "echo $code | php -l";

        return (preg_match('/No syntax errors detected in -/', $lint));
    }

    /**
     * @return array
     */
    public function getRowsToExport()
    {
        $array = [
            'name',
            'code',
            'php_code',
        ];

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Mirasvit\Feed\Model\ResourceModel\Dynamic\Variable::class);
    }
}
