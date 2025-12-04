<?php
/**
 * Generate Button Block for Admin Configuration
 */
declare(strict_types=1);

namespace SystemSixtyFour\LlmsTxtGenerator\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class GenerateButton extends Field
{
    /**
     * @var string
     */
    protected $_template = 'SystemSixtyFour_LlmsTxtGenerator::system/config/generate_button.phtml';

    /**
     * Render the element HTML
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * Get generate URL
     */
    public function getGenerateUrl(): string
    {
        return $this->getUrl('llmstxt/generate/index');
    }

    /**
     * Get button HTML
     */
    public function getButtonHtml(): string
    {
        $button = $this->getLayout()->createBlock(\Magento\Backend\Block\Widget\Button::class)
            ->setData([
                'id' => 'llmstxt_generate_button',
                'label' => __('Generate Now'),
                'class' => 'primary',
            ]);

        return $button->toHtml();
    }
}
