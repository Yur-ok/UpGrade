<?php

use yii\helpers\Html;

/** @var $countries */
?>
    <h1>Countries</h1>
    <ul>
        <?php
        foreach ($countries as $key => $country): ?>
            <li>
                <a href="/country/show?id=<?= $country->id ?>">#<?= Yii::t('app', 'Просмотр') ?></a>
                <?= Html::encode("{$country->code} ({$country->name})") ?>:
                <?= $country->population ?>
                <a href="/country/update?id=<?= $country->id ?>">#<?= Yii::t('app', 'Редактировать') ?></a>
                <a href="/country/delete?id=<?= $country->id ?>">#<?= Yii::t('app', 'Удалить') ?></a>
            </li>
        <?php
        endforeach; ?>
    </ul>

<div>
    <a class="btn btn-secondary" href="/country/create">#<?= Yii::t('app', 'Добавить ещё') ?></a>
</div>