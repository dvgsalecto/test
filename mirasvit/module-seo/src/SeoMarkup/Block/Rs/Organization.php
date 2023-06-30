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

namespace Mirasvit\SeoMarkup\Block\Rs;

use Magento\Directory\Model\RegionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\ListsInterface as LocaleListsInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Information as StoreInformation;
use Magento\Theme\Block\Html\Header\Logo;
use Mirasvit\Core\Service\SerializeService;
use Mirasvit\SeoMarkup\Model\Config\OrganizationConfig;

class Organization extends Template
{
    private $store;

    private $organizationConfig;

    private $context;

    private $localeLists;

    private $regionFactory;

    private $logo;

    public function __construct(
        OrganizationConfig $organizationConfig,
        LocaleListsInterface $localeLists,
        RegionFactory $regionFactory,
        Logo $logo,
        Context $context
    ) {
        $this->organizationConfig = $organizationConfig;
        $this->localeLists        = $localeLists;
        $this->regionFactory      = $regionFactory;
        $this->logo               = $logo;
        $this->context            = $context;

        $this->store = $context->getStoreManager()->getStore();

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        if (
            !$this->organizationConfig->isRsEnabled($this->store)
            || $this->getRequest()->getFullActionName() !== 'cms_index_index'
        ) {
            return false;
        }

        $data = $this->getJsonData();

        return '<script type="application/ld+json">' . SerializeService::encode($data) . '</script>';
    }

    private function getJsonData(): array
    {
        $data = [
            "@context" => "http://schema.org",
            "@type"    => "Organization",
        ];

        $values = [
            'url'       => $this->getBaseUrl(),
            'logo'      => $this->getLogoUrl(),
            'name'      => $this->getName(),
            'telephone' => $this->getTelephone(),
            'faxNumber' => $this->getFaxNumber(),
            'email'     => $this->getEmail()
        ];

        foreach ($values as $key => $value) {
            $value = trim($value);

            if ($value) {
                $data[$key] = $value;
            }
        }

        $values  = [
            'addressCountry'  => $this->getAddressCountry(),
            'addressLocality' => $this->getAddressLocality(),
            'postalCode'      => $this->getPostalCode(),
            'streetAddress'   => $this->getStreetAddress(),
            'addressRegion'   => $this->getAddressRegion(),
        ];
        $address = [];

        foreach ($values as $key => $value) {
            $value = trim($value);
            if ($value) {
                $address[$key] = $value;
            }
        }

        if (count($address)) {
            $data['address'] = array_merge([
                '@type' => 'PostalAddress',
            ], $address);
        }

        if ($socialLinks = $this->getSocialLinks()) {
            $data['sameAs'] = $socialLinks;
        }

        return $data;
    }

    private function getName(): string
    {
        if ($this->organizationConfig->isCustomName($this->store)) {
            return (string)$this->organizationConfig->getCustomName($this->store);
        }

        return (string)$this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_NAME);
    }

    private function getTelephone(): string
    {
        if ($this->organizationConfig->isCustomTelephone($this->store)) {
            return (string)$this->organizationConfig->getCustomTelephone($this->store);
        }

        return (string)$this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_PHONE);
    }

    private function getFaxNumber(): string
    {
        return (string)$this->organizationConfig->getCustomFaxNumber($this->store);
    }

    private function getEmail(): string
    {
        if ($this->organizationConfig->isCustomEmail($this->store)) {
            return (string)$this->organizationConfig->getCustomEmail($this->store);
        }

        return (string)$this->context->getScopeConfig()->getValue('trans_email/ident_general/email');
    }

    public function getAddressCountry(): string
    {
        if ($this->organizationConfig->isCustomAddressCountry($this->store)) {
            return (string)$this->organizationConfig->getCustomAddressCountry($this->store);
        }

        return (string)$this->localeLists->getCountryTranslation(
            $this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_COUNTRY_CODE)
        );
    }

    public function getAddressLocality(): string
    {
        if ($this->organizationConfig->isCustomAddressLocality($this->store)) {
            return (string)$this->organizationConfig->getCustomAddressLocality($this->store);
        }

        return (string)$this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_CITY);
    }

    public function getPostalCode(): string
    {
        if ($this->organizationConfig->isCustomPostalCode($this->store)) {
            return (string)$this->organizationConfig->getCustomPostalCode($this->store);
        }

        return (string)$this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_POSTCODE);
    }

    public function getStreetAddress(): string
    {
        if ($this->organizationConfig->isCustomStreetAddress($this->store)) {
            return (string)$this->organizationConfig->getCustomStreetAddress($this->store);
        }

        return $this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_STREET_LINE1)
            . ' '
            . $this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_STREET_LINE2);
    }

    public function getAddressRegion(): string
    {
        if ($this->organizationConfig->isCustomAddressRegion($this->store)) {
            return (string)$this->organizationConfig->getCustomAddressRegion($this->store);
        }

        $regionId = $this->store->getConfig(StoreInformation::XML_PATH_STORE_INFO_REGION_CODE);

        return (string)$this->regionFactory->create()->load($regionId)->getCode();
    }

    public function getLogoUrl()
    {
        // fix since Magento_Theme v101.1.4
        if (class_exists('Magento\Theme\ViewModel\Block\Html\Header\LogoPathResolver') && !$this->logo->getData('logoPathResolver')) {
            $logoPathResolver = ObjectManager::getInstance()->get('Magento\Theme\ViewModel\Block\Html\Header\LogoPathResolver');
            $this->logo->setData('logoPathResolver', $logoPathResolver);
        }
        
        return (string)$this->logo->getLogoSrc();
    }

    public function getBaseUrl(): string
    {
        return (string)$this->context->getUrlBuilder()->getBaseUrl();
    }

    public function getSocialLinks(): array
    {
        return $this->organizationConfig->getSocialLinks($this->store);
    }
}
