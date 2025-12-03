<?php
/**
 * System64 LLMs TXT Generator Module
 *
 * Generates llms.txt file for AI crawlers (ChatGPT, Claude, Gemini, Perplexity)
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'System64_LlmsTxtGenerator',
    __DIR__
);
