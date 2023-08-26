<?php

use app\models\Country;
use yii\helpers\Html;

/** @var $country Country */

?>
<p><?= Yii::t('app', 'Вы ввели следующую информацию:') ?></p>

<ul>
    <li><label>Code</label>: <?= Html::encode($country->code) ?></li>
    <li><label>Name</label>: <?= Html::encode($country->name) ?></li>
    <li><label>Population</label>: <?= Html::encode($country->population) ?></li>
</ul>

<a class="btn btn-warning" href="/crud/create/"><?= Yii::t('app', 'Добавить ещё') ?></a>