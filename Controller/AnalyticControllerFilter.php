<?php

namespace Kanboard\Plugin\AverageTimeByColumnFilter\Controller;

use Kanboard\Controller\AnalyticController;

class AnalyticControllerFilter extends AnalyticController
{
    /**
     * Show average time spent by column with filter
     *
     * @access public
     */
    public function averageTimeByColumnFilter()
    {   

        $project = $this->getProject();
        list($from, $to) = $this->getDates();
        $limit = $this->request->getIntegerParam('limit', 4000);
        $this->response->html(
            $this->helper->layout->analytic('AverageTimeByColumnFilter:avg_time_columns_filter', array(
                'values' => array(
                    'from' => $from,
                    'to' => $to,
                    'limit' => $limit,
                ),
                'project' => $project,
                'metrics' => $this->averageTimeSpentColumnAnalyticFilter->build_with_date($project['id'], $from, $to, $limit),
                'title' => t('Average time spent into each column'),
            ))
        );
    }

    private function getDates()
    {
    $values = $this->request->getValues();
    $from = $this->request->getStringParam('from', date('Y-m-d', strtotime('-1month')));
    $to = $this->request->getStringParam('to', date('Y-m-d'));
    $values += array(
        'from' => $from,
        'to' => $to,
    );
    if (!empty($values)) {
        $from = $this->dateParser->getIsoDate($values['from']);
        $to = $this->dateParser->getIsoDate($values['to']);
    }
    return array($from, $to);
}
}

