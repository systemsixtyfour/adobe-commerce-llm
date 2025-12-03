<?php
/**
 * Configuration Helper for LLMs TXT Generator
 */
declare(strict_types=1);

namespace System64\LlmsTxtGenerator\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    private const XML_PATH_ENABLED = 'llmstxt_generator/general/enabled';
    private const XML_PATH_ENTITY_TYPES = 'llmstxt_generator/general/entity_types';
    private const XML_PATH_COMPANY_NAME = 'llmstxt_generator/company/name';
    private const XML_PATH_COMPANY_DESC = 'llmstxt_generator/company/description';
    private const XML_PATH_ADDITIONAL_INFO = 'llmstxt_generator/company/additional_info';
    private const XML_PATH_CRON_FREQUENCY = 'llmstxt_generator/cron/frequency';
    private const XML_PATH_CRON_TIME = 'llmstxt_generator/cron/time';
    private const XML_PATH_MAX_PRODUCTS = 'llmstxt_generator/limits/max_products';
    private const XML_PATH_MAX_CATEGORIES = 'llmstxt_generator/limits/max_categories';
    private const XML_PATH_MAX_CMS_PAGES = 'llmstxt_generator/limits/max_cms_pages';
    private const XML_PATH_INCLUDE_DISABLED = 'llmstxt_generator/limits/include_disabled_products';

    private ScopeConfigInterface $scopeConfig;
    private StoreManagerInterface $storeManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Check if module is enabled
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get selected entity types
     */
    public function getEntityTypes(?int $storeId = null): array
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_ENTITY_TYPES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $value ? explode(',', $value) : [];
    }

    /**
     * Get company name
     */
    public function getCompanyName(?int $storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_COMPANY_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get company description
     */
    public function getCompanyDescription(?int $storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_COMPANY_DESC,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get additional info
     */
    public function getAdditionalInfo(?int $storeId = null): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_ADDITIONAL_INFO,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get cron frequency
     */
    public function getCronFrequency(): string
    {
        return (string) $this->scopeConfig->getValue(self::XML_PATH_CRON_FREQUENCY);
    }

    /**
     * Get cron time
     */
    public function getCronTime(): array
    {
        $time = $this->scopeConfig->getValue(self::XML_PATH_CRON_TIME);
        return $time ? explode(',', $time) : ['02', '00', '00'];
    }

    /**
     * Get max products limit
     */
    public function getMaxProducts(?int $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_MAX_PRODUCTS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get max categories limit
     */
    public function getMaxCategories(?int $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_MAX_CATEGORIES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get max CMS pages limit
     */
    public function getMaxCmsPages(?int $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_MAX_CMS_PAGES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if disabled products should be included
     */
    public function includeDisabledProducts(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_INCLUDE_DISABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get base URL for store
     */
    public function getBaseUrl(?int $storeId = null): string
    {
        return $this->storeManager->getStore($storeId)->getBaseUrl();
    }

    /**
     * Get store name
     */
    public function getStoreName(?int $storeId = null): string
    {
        return $this->storeManager->getStore($storeId)->getName();
    }
}
