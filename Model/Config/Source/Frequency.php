<?php
/**
 * Frequency Source Model
 */
declare(strict_types=1);

namespace SystemSixtyFour\LlmsTxtGenerator\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Frequency implements OptionSourceInterface
{
    public const CRON_DAILY = 'D';
    public const CRON_WEEKLY = 'W';
    public const CRON_MONTHLY = 'M';

    /**
     * Get available frequency options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::CRON_DAILY, 'label' => __('Daily')],
            ['value' => self::CRON_WEEKLY, 'label' => __('Weekly')],
            ['value' => self::CRON_MONTHLY, 'label' => __('Monthly')],
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
            self::CRON_DAILY => __('Daily'),
            self::CRON_WEEKLY => __('Weekly'),
            self::CRON_MONTHLY => __('Monthly'),
        ];
    }
}
