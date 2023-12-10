<li <?= $this->app->checkMenuSelection('AnalyticControllerFilter', 'averageTimeByColumnFilter') ?>>
    <?= $this->modal->replaceLink(t('Average time per column with filter'), 'AnalyticControllerFilter', 'averageTimeByColumnFilter', array('plugin' => 'AverageTimeByColumnFilter', 'project_id' => $project['id'])) ?>
</li>