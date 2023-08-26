<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var $countries */
/** @var $pagination */
?>
    <h1>Countries</h1>
    <ul>
        <?php
        foreach ($countries as $key => $country): ?>
            <li>
                <a href="/crud/update?id=<?= $country->id ?>">#<?= Yii::t('app', 'Редактировать') ?></a>
                <?= Html::encode("{$country->code} ({$country->name})") ?>:
                <?= $country->population ?>
                <a href="/crud/delete?id=<?= $country->id ?>">#<?= Yii::t('app', 'Удалить') ?></a>
            </li>
        <?php
        endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>