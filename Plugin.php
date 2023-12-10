<?php

namespace Kanboard\Plugin\AverageTimeByColumnFilter;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base 
{
    public function initialize()
    {
        $this->route->addRoute('analytics/average-time-column/:project_id', 'AnalyticControllerFilter', 'averageTimeByColumn', 'AverageTimeByColumnFilter');
        $this->template->hook->attach("template:analytic:sidebar","AverageTimeByColumnFilter:analytic/sidebar");
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getClasses()
    {
        return [
            'Plugin\AverageTimeByColumnFilter\Analytics' => [
                'AverageTimeSpentColumnAnalyticFilter',
            ],
        ];
    }
    public function getPluginName()
    {
        return 'AverageTimeByColumnFilter';
    }

    public function getPluginDescription()
    {
        return t('Adds filters to the average time spent by column chart. ');
    }

    public function getPluginAuthor()
    {
        return 'Douglas Lambertinny';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

}
