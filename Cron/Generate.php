<?php
/**
 * Cron Job for LLMs TXT Generator
 */
declare(strict_types=1);

namespace System64\LlmsTxtGenerator\Cron;

use System64\LlmsTxtGenerator\Model\Generator;
use System64\LlmsTxtGenerator\Model\Config;
use Psr\Log\LoggerInterface;

class Generate
{
    private Generator $generator;
    private Config $config;
    private LoggerInterface $logger;

    public function __construct(
        Generator $generator,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->generator = $generator;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Execute cron job to generate llms.txt
     */
    public function execute(): void
    {
        try {
            if (!$this->config->isEnabled()) {
                $this->logger->debug('LLMs TXT Generator Cron: Module is disabled, skipping generation');
                return;
            }

            $this->logger->info('LLMs TXT Generator Cron: Starting scheduled generation');

            $result = $this->generator->generate();

            if ($result) {
                $this->logger->info('LLMs TXT Generator Cron: File generated successfully');
            } else {
                $this->logger->warning('LLMs TXT Generator Cron: File generation returned false');
            }

        } catch (\Exception $e) {
            $this->logger->error('LLMs TXT Generator Cron: Error during generation - ' . $e->getMessage());
        }
    }
}
