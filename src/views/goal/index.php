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
            <?php if ($goal->completed): ?>
                <?= Html::tag('s', Html::a(Html::encode($goal->title), ['view', 'id' => $goal->id])) ?>
                <?= Html::tag('s', Html::encode($goal->description)) ?>
            <?php else: ?>
                <?= Html::a(Html::encode($goal->title), ['view', 'id' => $goal->id]) ?>:
                <?= Html::encode($goal->description) ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>

</ul>
