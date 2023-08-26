<?php

use app\models\Country;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $country Country */


$form = ActiveForm::begin() ?>
<?= $form->field($country, 'code')->label('Код') ?>
<?= $form->field($country, 'name')->label('Название') ?>
<?= $form->field($country, 'population')->label('Численность') ?>

<div class='form-group'>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end() ?>


