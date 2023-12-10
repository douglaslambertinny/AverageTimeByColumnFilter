<?php

namespace Kanboard\Plugin\AnalyticCustom\Analytics;

use Kanboard\Analytic\AverageTimeSpentColumnAnalytic;
use Kanboard\Model\TaskModel;


class AverageTimeSpentColumnAnalyticFilter extends AverageTimeSpentColumnAnalytic {

    public function build_with_date($project_id, $from, $to, $limit)
    {
        if (!is_numeric($from)) {
            $from = $this->dateParser->removeTimeFromTimestamp($this->dateParser->getTimestamp($from));
        }

        if (!is_numeric($to)) {
            $to = $this->dateParser->removeTimeFromTimestamp(strtotime('+1 day', $this->dateParser->getTimestamp($to)));
        }

        $stats = $this->initialize($project_id);
        $this->processTasks($stats, $project_id, $from, $to, $limit);
        $this->calculateAverage($stats);
        return $stats;
    }

    private function initialize($project_id)
    {
        
        $stats = array();
        $columns = $this->columnModel->getList($project_id);
        
        foreach ($columns as $column_id => $column_title) {
            $stats[$column_id] = array(
                'count' => 0,
                'time_spent' => 0,
                'average' => 0,
                'title' => $column_title,
                
            );
        }
        
        return $stats;
    }
    
    private function processTasks(array &$stats, $project_id, $from, $to, $limit)
    {
        $tasks = $this->getTasks($project_id, $from, $to, $limit);
        foreach ($tasks as &$task) {
            foreach ($this->getTaskTimeByColumns($task) as $column_id => $time_spent) {
                if (isset($stats[$column_id])) {
                    $stats[$column_id]['count']++;
                    $stats[$column_id]['time_spent'] += $time_spent;
                }
            }
        }
    }
    
    private function calculateColumnAverage(array &$column)
    {
        if ($column['count'] > 0) {
            $column['average'] = (int) ($column['time_spent'] / $column['count']);
        }
    }
    
    private function calculateAverage(array &$stats)
    {
        foreach ($stats as &$column) {
            $this->calculateColumnAverage($column);
        }
    }
    
    
    private function getTaskTimeByColumns(array &$task)
    {
        $columns = $this->transitionModel->getTimeSpentByTask($task['id']);
        
        if (!isset($columns[$task['column_id']])) {
            $columns[$task['column_id']] = 0;
        }
        
        $columns[$task['column_id']] += $this->getTaskTimeSpentInCurrentColumn($task);
        
        return $columns;
    }
    
    private function getTaskTimeSpentInCurrentColumn(array &$task)
    {
        $end = $task['date_completed'] ?: time();
        return $end - $task['date_moved'];
    }
    
    private function getTasks($project_id, $from, $to, $limit)
    {
        return $this->db
            ->table(TaskModel::TABLE)
            ->columns('id', 'date_completed', 'date_moved', 'column_id')
            ->eq('project_id', $project_id)
            ->gte('date_completed', $from)
            ->lte('date_completed', $to)
            ->desc('id')
            ->limit($limit)
            ->findAll();
    }
}