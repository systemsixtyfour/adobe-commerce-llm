<?php
/**
 * Generate Controller for Admin
 */
declare(strict_types=1);

namespace System64\LlmsTxtGenerator\Controller\Adminhtml\Generate;

use System64\LlmsTxtGenerator\Model\Generator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends Action
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'System64_LlmsTxtGenerator::config';

    private Generator $generator;
    private JsonFactory $jsonFactory;

    public function __construct(
        Context $context,
        Generator $generator,
        JsonFactory $jsonFactory
    ) {
        $this->generator = $generator;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * Execute generation
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();

        try {
            $success = $this->generator->generate();

            if ($success) {
                return $result->setData([
                    'success' => true,
                    'message' => __('LLMs.txt file generated successfully!'),
                    'url' => $this->generator->getFileUrl(),
                    'path' => $this->generator->getFilePath()
                ]);
            } else {
                return $result->setData([
                    'success' => false,
                    'message' => __('Failed to generate llms.txt file. Please check if the module is enabled.')
                ]);
            }

        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => __('Error: %1', $e->getMessage())
            ]);
        }
    }
}
