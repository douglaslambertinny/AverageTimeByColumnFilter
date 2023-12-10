<?php

namespace Kanboard\Plugin\AverageTimeByColumnFilter;

use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\AnalyticCustom\Analytics\AverageTimeSpentColumnAnalyticFilter;

class Plugin extends Base 
{
    public function initialize()
    {
        $this->route->addRoute('analytics/average-time-column/:project_id', 'AnalyticControllerFilter', 'averageTimeByColumn', 'AnalyticCustom');
        $this->template->hook->attach("template:analytic:sidebar","AnalyticCustom:analytic/sidebar");
    }

    // public function onStartup()
    // {
    //     Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    // }

    public function getClasses()
    {
        return [
            'Plugin\AnalyticCustom\Analytics' => [
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
