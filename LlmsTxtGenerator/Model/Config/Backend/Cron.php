<?php
/**
 * Cron Backend Model
 *
 * Handles saving the cron expression based on frequency and time settings
 */
declare(strict_types=1);

namespace System64\LlmsTxtGenerator\Model\Config\Backend;

use System64\LlmsTxtGenerator\Model\Config\Source\Frequency;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Cron extends Value
{
    private const CRON_STRING_PATH = 'llmstxt_generator/cron/cron_expr';
    private const CRON_MODEL_PATH = 'llmstxt_generator/cron/cron_model';

    protected ValueFactory $configValueFactory;
    protected string $runModelPath = '';

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ValueFactory $configValueFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        string $runModelPath = '',
        array $data = []
    ) {
        $this->configValueFactory = $configValueFactory;
        $this->runModelPath = $runModelPath;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * After save - generate cron expression
     */
    public function afterSave()
    {
        $time = $this->getData('groups/cron/fields/time/value');
        $frequency = $this->getData('groups/cron/fields/frequency/value');

        $cronExprArray = [
            (int) ($time[1] ?? 0),                    // Minute
            (int) ($time[0] ?? 2),                    // Hour
            $frequency == Frequency::CRON_MONTHLY ? '1' : '*',  // Day of Month
            '*',                                      // Month
            $frequency == Frequency::CRON_WEEKLY ? '1' : '*',   // Day of Week
        ];

        $cronExprString = implode(' ', $cronExprArray);

        try {
            $this->configValueFactory->create()->load(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                self::CRON_STRING_PATH
            )->save();

            $this->configValueFactory->create()->load(
                self::CRON_MODEL_PATH,
                'path'
            )->setValue(
                $this->runModelPath
            )->setPath(
                self::CRON_MODEL_PATH
            )->save();

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Unable to save the cron expression.')
            );
        }

        return parent::afterSave();
    }
}
