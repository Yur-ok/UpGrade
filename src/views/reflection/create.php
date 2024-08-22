<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Goal */
/* @var $tasks array */

$this->title = 'Create Goal';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="goal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // Генерация полей формы на основе правил валидации модели Goal
    $renderedFields = [];
    foreach ($model->rules() as $rule) {
        $attributes = (array) $rule[0];
        foreach ($attributes as $attribute) {
            if (in_array($attribute, ['id', 'deleted_at', 'created_at', 'updated_at', 'completed']) || isset
                ($renderedFields[$attribute])) {
                continue;
            }
            echo $form->field($model, $attribute)->textInput(['maxlength' => true]);
            $renderedFields[$attribute] = true;
        }
    }
    ?>

    <h2>Tasks</h2>
    <?php for ($i = 0; $i < 3; $i++): ?>
        <div class="visually-hidden"><?= $n = $i + 1 ?></div>
        <div class="task-form">
            <?= $form->field($tasks[$i], "[$i]title")->textInput(['maxlength' => true])->label("#$n Task Title") ?>
            <?= $form->field($tasks[$i], "[$i]description")->textarea(['rows' => 3])->label("#$n Task Description") ?>
        </div>
        <hr>
    <?php endfor; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
