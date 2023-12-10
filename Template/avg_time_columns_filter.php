<?php if (!$is_ajax) : ?>
    <div class="page-header">
        <h2><?= t('Average time spent in each column') ?></h2>
    </div>
<?php endif ?>

<?php if (empty($metrics)) : ?>

    <p class="alert"><?= t('Not enough data to show the graph.') ?></p>
    <form method="post" class="form-inline" action="<?= $this->url->href('AnalyticControllerFilter', 'averageTimeByColumnFilter', array('plugin' => 'AverageTimeByColumnFilter','project_id' => $project['id'])) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>
        <!-- Set value default values -->
        <?= $this->form->date(t('Start date'), 'from', $values) ?>
        <?= $this->form->date(t('End date'), 'to', $values) ?>
        <!-- define limit -->
        <?= $this->form->label(t('Task limit'), 'limit') ?>
        <?= $this->form->number('limit', $limit, array(), array(), 'form-numeric') ?>
        <?= $this->modal->submitButtons(array('submitLabel' => t('Execute'))) ?>
    </form>
    <?php else : ?>
    <?= $this->app->component('chart-project-avg-time-column', array(
        'metrics' => $metrics,
        'label' => t('Average time spent'),
    )) ?>

    <table class="table-striped">
        <tr>
            <th><?= t('Column') ?></th>
            <th><?= t('Average time spent') ?></th>
        </tr>
        <?php foreach ($metrics as $column) : ?>
            <tr>
                <td><?= $this->text->e($column['title']) ?></td>
                <td><?= $this->dt->duration($column['average']) ?></td>
            </tr>
        <?php endforeach ?>
    </table>

    <?php 
    ?>
    <form method="post" class="form-inline" action="<?= $this->url->href('AnalyticControllerFilter', 'averageTimeByColumnFilter', array('plugin' => 'AverageTimeByColumnFilter', 'project_id' => $project['id'])) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>
        <?= $this->form->date(t('Start date'), 'from', $values) ?>
        <?= $this->form->date(t('End date'), 'to', $values) ?>
        <?= $this->form->label(t('Task limit'), 'limit') ?>
        <?= $this->form->number('limit', $values, array(), array(), 'form-numeric') ?>
        <?= $this->modal->submitButtons(array('submitLabel' => t('Execute'))) ?>
    </form>

    <p class="alert alert-info">
        <?= t('This chart shows the average time spent in each column for the last %d tasks.', $values['limit']) ?>
    </p>
<?php endif ?>