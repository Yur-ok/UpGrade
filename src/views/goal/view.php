<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $goal app\models\Goal */
/* @var $tasks app\models\Task[] */

$this->title = $goal->title;
?>
<?php
if ($goal->completed): ?>
    <h1><?= Html::tag('s', Html::encode($this->title)) ?></h1>
<?php
else: ?>
    <h1><?= Html::encode($this->title) ?></h1>
<?php
endif; ?>

<p><?= Html::encode($goal->description) ?></p>

<div class="btn-group">
    <?php
    if (Yii::$app->user->can('manageGoal')): ?>
        <?= Html::a('Update Goal', ['update', 'id' => $goal->id], ['class' => 'btn btn-primary']) ?>
    <?php
    endif; ?>

    <?php
    if (Yii::$app->user->can('deleteGoal')): ?>
        <?= Html::a('Delete Goal', ['delete-goal', 'id' => $goal->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this goal?',
                'method' => 'post',
            ],
        ]) ?>
    <?php
    endif; ?>

    <?php
    if (Yii::$app->user->can('completeGoal')): ?>
        <?php
        if (!$goal->completed): ?>
            <?= Html::a('Complete Goal', ['complete-goal', 'id' => $goal->id], ['class' => 'btn btn-success']) ?>
        <?php
        endif; ?>
    <?php
    endif; ?>
</div>

<h2>Tasks</h2>
<ul>
    <?php
    foreach ($tasks as $task): ?>
        <li>
            <?php
            if (!$task->completed): ?>
                <?= Html::encode($task->title) ?>: <?= Html::encode($task->description) ?>
            <?php
            else: ?>
                <?= Html::tag('s', Html::encode($task->title)) ?>: <?= Html::tag('s',Html::encode($task->description)) ?>
            <?php
            endif; ?>

            <?php
            if (!$task->completed): ?>
                <?php if (Yii::$app->user->can('completeTask')): ?>
                    <?= Html::a('Complete Task', ['complete-task', 'id' => $task->id], ['class' => 'btn btn-success btn-sm']) ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (Yii::$app->user->can('deleteTask')): ?>
                <?= Html::a('Delete Task', ['delete-task', 'id' => $task->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this task?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </li>
    <?php
    endforeach; ?>
</ul>

<p>
    <?= Html::a('Add Task', ['add-task', 'goalId' => $goal->id], ['class' => 'btn btn-primary']) ?>
</p>
