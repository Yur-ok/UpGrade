<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Goal */
/* @var $formHtml string */

$this->title = 'Create Goal via Reflection';
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="goal-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $formHtml ?>
</div>
