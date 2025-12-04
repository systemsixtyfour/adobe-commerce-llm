<?php
/**
 * Status Block for Admin Configuration
 */
declare(strict_types=1);

namespace SystemSixtyFour\LlmsTxtGenerator\Block\Adminhtml\System\Config;

use SystemSixtyFour\LlmsTxtGenerator\Model\Generator;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Status extends Field
{
    private Generator $generator;

    public function __construct(
        Context $context,
        Generator $generator,
        array $data = []
    ) {
        $this->generator = $generator;
        parent::__construct($context, $data);
    }

    /**
     * Render the element HTML
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $fileExists = $this->generator->fileExists();

        if ($fileExists) {
            $modTime = $this->generator->getFileModificationTime();
            $fileUrl = $this->generator->getFileUrl();

            $html = '<div style="padding: 10px; background: #e8f5e9; border-radius: 4px; border: 1px solid #4caf50;">';
            $html .= '<strong style="color: #2e7d32;">✓ File exists</strong><br>';
            $html .= '<span style="color: #666;">Last generated: ' . $modTime . ' UTC</span><br>';
            $html .= '<a href="' . $fileUrl . '" target="_blank" style="color: #1976d2;">View llms.txt →</a>';
            $html .= '</div>';
        } else {
            $html = '<div style="padding: 10px; background: #fff3e0; border-radius: 4px; border: 1px solid #ff9800;">';
            $html .= '<strong style="color: #e65100;">⚠ File not generated yet</strong><br>';
            $html .= '<span style="color: #666;">Click "Generate Now" to create the llms.txt file</span>';
            $html .= '</div>';
        }

        return $html;
    }
}
