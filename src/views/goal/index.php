<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $goals app\models\Goal[] */

$this->title = 'Мои Цели';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Создать Цель', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<ul>
    <?php foreach ($goals as $goal): ?>
        <li>
            <?= Html::a(Html::encode($goal->title), ['view', 'id' => $goal->id]) ?>:
            <?= Html::encode($goal->description) ?>
        </li>
    <?php endforeach; ?>
</ul>
