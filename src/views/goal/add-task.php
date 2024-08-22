<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $task app\models\Task */

$this->title = 'Добавить Задачу';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($task, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($task, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
