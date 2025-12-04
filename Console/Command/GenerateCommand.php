<?php
/**
 * CLI Command for LLMs TXT Generator
 */
declare(strict_types=1);

namespace SystemSixtyFour\LlmsTxtGenerator\Console\Command;

use SystemSixtyFour\LlmsTxtGenerator\Model\Generator;
use SystemSixtyFour\LlmsTxtGenerator\Model\Config;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    private const OPTION_STORE = 'store';
    private const OPTION_FORCE = 'force';

    private Generator $generator;
    private Config $config;
    private StoreManagerInterface $storeManager;

    public function __construct(
        Generator $generator,
        Config $config,
        StoreManagerInterface $storeManager,
        ?string $name = null
    ) {
        $this->generator = $generator;
        $this->config = $config;
        $this->storeManager = $storeManager;
        parent::__construct($name);
    }

    /**
     * Configure the command
     */
    protected function configure(): void
    {
        $this->setName('llmstxt:generate')
            ->setDescription('Generate the llms.txt file for AI crawlers')
            ->addOption(
                self::OPTION_STORE,
                's',
                InputOption::VALUE_OPTIONAL,
                'Store ID to generate for (default: default store)',
                null
            )
            ->addOption(
                self::OPTION_FORCE,
                'f',
                InputOption::VALUE_NONE,
                'Force generation even if module is disabled'
            );
    }

    /**
     * Execute the command
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $storeId = $input->getOption(self::OPTION_STORE);
        $force = $input->getOption(self::OPTION_FORCE);

        if ($storeId !== null) {
            $storeId = (int) $storeId;
        }

        $output->writeln('<info>LLMs TXT Generator</info>');
        $output->writeln('');

        // Check if module is enabled
        if (!$force && !$this->config->isEnabled($storeId)) {
            $output->writeln('<error>Module is disabled. Use --force to generate anyway.</error>');
            return Command::FAILURE;
        }

        // Show configuration summary
        $output->writeln('<comment>Configuration:</comment>');
        $output->writeln('  Store ID: ' . ($storeId ?? 'default'));
        $output->writeln('  Entity Types: ' . implode(', ', $this->config->getEntityTypes($storeId)));
        $output->writeln('  Company Name: ' . ($this->config->getCompanyName($storeId) ?: 'Not set'));
        $output->writeln('');

        $output->writeln('<info>Generating llms.txt file...</info>');

        try {
            // Temporarily enable if forcing
            $result = $this->generator->generate($storeId);

            if ($result) {
                $output->writeln('<info>✓ File generated successfully!</info>');
                $output->writeln('');
                $output->writeln('<comment>File Details:</comment>');
                $output->writeln('  Path: ' . $this->generator->getFilePath());
                $output->writeln('  URL: ' . $this->generator->getFileUrl($storeId));
                $output->writeln('  Generated: ' . $this->generator->getFileModificationTime());
                return Command::SUCCESS;
            } else {
                $output->writeln('<error>✗ File generation failed. Check logs for details.</error>');
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $output->writeln('<error>✗ Error: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
