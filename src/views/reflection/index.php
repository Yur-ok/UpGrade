<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $goals app\models\Goal[] */

$this->title = 'Reflection API Example';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Create GoalManager', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<h2>Existing Goals</h2>
<ul>
    <?php
    foreach ($goals as $goal): ?>
        <li>
            <?= Html::tag('strong', Html::encode($goal->title)) ?>:   <?= Html::encode($goal->description) ?>
        </li>
    <?php
    endforeach; ?>
</ul>
