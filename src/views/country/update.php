<?php

use app\models\Country;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $country Country */


$form = ActiveForm::begin() ?>
<?= $form->field($country, 'code')->label(Yii::t('app', 'Код')) ?>
<?= $form->field($country, 'name')->label(Yii::t('app', 'Название')) ?>
<?= $form->field($country, 'population')->label(Yii::t('app', 'Численность')) ?>

<div class='form-group'>
    <?= Html::submitButton(Yii::t('app', 'Обновить'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end() ?>
