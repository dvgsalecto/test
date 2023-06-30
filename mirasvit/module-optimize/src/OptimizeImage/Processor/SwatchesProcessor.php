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
 * @package   mirasvit/module-optimize
 * @version   1.5.1
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


declare(strict_types=1);


namespace Mirasvit\OptimizeImage\Processor;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\Optimize\Api\Processor\OutputProcessorInterface;
use Mirasvit\OptimizeImage\Model\Config;
use Mirasvit\OptimizeImage\Repository\FileRepository;
use Mirasvit\OptimizeImage\Service\FileListSynchronizationService;

class SwatchesProcessor implements OutputProcessorInterface
{
    private $config;

    private $mediaUrl;

    private $mediaDir;

    private $fileRepository;

    private $syncService;

    public function __construct(
        Config $config,
        FileRepository $fileRepository,
        FileListSynchronizationService $syncService,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->config         = $config;
        $this->fileRepository = $fileRepository;
        $this->syncService    = $syncService;
        $this->mediaUrl       = $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $this->mediaDir       = $filesystem->getDirectoryread(DirectoryList::MEDIA);
    }

    public function process($content)
    {
        if(!$this->config->isUseWebpForFotorama()) {
            return $content;
        }

        $content = preg_replace_callback(
            '/<script type="text\/x-magento-init">([^<]*?data-role=swatch-options.*?)<\/script>/ims',
            [$this, 'replaceCallback'],
            $content
        );

        return $content;
    }

    /**
     * @param array $match
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Zend_Json_Exception
     */
    private function replaceCallback(array $match)
    {
        $imgKeys = ['thumb', 'img', 'full'];
        $config  = SerializeService::decode($match[1]);

        if (!isset($config["[data-role=swatch-options]"])) {
            return $match[0];
        }

        $widgetConfig = $config["[data-role=swatch-options]"];

        $dataKey = array_keys($widgetConfig)[0];

        if (!isset($widgetConfig[$dataKey]['jsonConfig']) || !isset($widgetConfig[$dataKey]['jsonConfig']['images'])) {
            return $match[0];
        }

        foreach ($widgetConfig[$dataKey]['jsonConfig']['images'] as $optionId => $optionData) {
            foreach ($optionData as $idx => $imageConfig) {
                if ($imageConfig["type"] !== 'image' && $imageConfig["type"] !== 'video') {
                    continue;
                }

                foreach ($imageConfig as $key => $value) {
                    if(!in_array($key, $imgKeys) || strpos($value, '.webp') !== false) {
                        continue;
                    }

                    preg_match('/\?.*/is', $value, $query);

                    $query = count($query) ? $query[0] : '';
                    $value = str_replace($query, '', $value);

                    $absolutePath = $this->config->retrieveImageAbsPath($value);

                    if (!$absolutePath) {
                        continue;
                    }

                    $image = $this->syncService->ensureFile($absolutePath);

                    if($image && $image->getWebpPath()) {
                        $path     = str_replace($this->mediaUrl, '', $value);
                        $webpPath = $path . Config::WEBP_SUFFIX;

                        if (!$this->mediaDir->isExist($webpPath)) {
                            $image->setWebpPath(null);
                            $this->fileRepository->save($image);
                            continue;
                        }

                        $webpUrl = str_replace($path, $webpPath, $value);

                        $imageConfig[$key] = $webpUrl . $query;
                    }
                }

                $optionData[$idx] = $imageConfig;
            }

            $widgetConfig[$dataKey]['jsonConfig']['images'][$optionId] = $optionData;
        }

        $config["[data-role=swatch-options]"] = $widgetConfig;

        $serializedKey = str_replace('/', '\/', $dataKey);

        $script = SerializeService::encode($config);
        $script = str_replace($serializedKey, $dataKey, $script);

        return '<script type="text/x-magento-init">' . $script . '</script>';
    }
}
