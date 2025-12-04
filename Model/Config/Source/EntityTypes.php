<?php
/**
 * Entity Types Source Model
 */
declare(strict_types=1);

namespace SystemSixtyFour\LlmsTxtGenerator\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class EntityTypes implements OptionSourceInterface
{
    /**
     * Get available entity types for llms.txt generation
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'cms_pages', 'label' => __('CMS Pages')],
            ['value' => 'products', 'label' => __('Products')],
            ['value' => 'categories', 'label' => __('Categories')],
        ];
    }

    /**
     * Get options as key-value pairs
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'cms_pages' => __('CMS Pages'),
            'products' => __('Products'),
            'categories' => __('Categories'),
        ];
    }
}
