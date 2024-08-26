<?php

namespace app\traits;

use Yii;

trait AdvancedLogTrait
{
    public function logAction($action, $details = [])
    {
        $message = "User action: $action";
        if (!empty($details)) {
            $message .= ' | Details: ' . json_encode($details);
        }
        Yii::info($message, 'GoalController');
    }

    public function logError($error, $details = [])
    {
        $message = "Error: $error";
        if (!empty($details)) {
            $message .= ' | Details: ' . json_encode($details);
        }
        Yii::error($message, 'GoalController');
    }

    public function logEvent($event, $level = 'info', $details = [])
    {
        $message = "Event: $event";
        if (!empty($details)) {
            $message .= ' | Details: ' . json_encode($details);
        }

        if ($level === 'info') {
            Yii::info($message, 'GoalController');
        } elseif ($level === 'warning') {
            Yii::warning($message, 'GoalController');
        } else {
            Yii::error($message, 'GoalController');
        }
    }
}
