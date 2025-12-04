<?php
/**
 * SystemSixtyFour LLMs TXT Generator Module
 *
 * Generates llms.txt file for AI crawlers (ChatGPT, Claude, Gemini, Perplexity)
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'SystemSixtyFour_LlmsTxtGenerator',
    __DIR__
);
