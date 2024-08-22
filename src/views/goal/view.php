<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $goal app\models\Goal */
/* @var $tasks app\models\Task[] */

$this->title = $goal->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::encode($goal->description) ?></p>

<div class="btn-group">
    <?php if (!$goal->completed): ?>
        <?= Html::a('Complete Goal', ['complete-goal', 'id' => $goal->id], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
    <?= Html::a('Delete Goal', ['delete-goal', 'id' => $goal->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this goal?',
            'method' => 'post',
        ],
    ]) ?>
</div>

<h2>Tasks</h2>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?= Html::encode($task->title) ?>: <?= Html::encode($task->description) ?>
            <?php if (!$task->completed): ?>
                <?= Html::a('Complete Task', ['complete-task', 'id' => $task->id], ['class' => 'btn btn-success btn-sm']) ?>
            <?php endif; ?>
            <?= Html::a('Delete Task', ['delete-task', 'id' => $task->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this task?',
                    'method' => 'post',
                ],
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>

<p>
    <?= Html::a('Add Task', ['add-task', 'goalId' => $goal->id], ['class' => 'btn btn-primary']) ?>
</p>
