<li <?= $this->app->checkMenuSelection('AnalyticControllerFilter', 'averageTimeByColumnCustom') ?>>
    <?= $this->modal->replaceLink(t('Average time per column with filter'), 'AnalyticControllerFilter', 'averageTimeByColumnCustom', array('plugin' => 'AverageTimeByColumnFilter', 'project_id' => $project['id'])) ?>
</li>