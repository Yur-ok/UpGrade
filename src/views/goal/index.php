<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Goals Management';
?>

<div class="goal-index" xmlns="http://www.w3.org/1999/html">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Форма для добавления новой цели -->
    <div class="goal-form">
        <input type="text" id="goalTitle" placeholder="Enter goal title">
        <br>
        <br>
        <textarea id="goalDescription" placeholder="Enter goal description"></textarea>
        <br>
        <button id="addGoalBtn">Add Goal</button>
    </div>
    <br>

    <!-- Список целей -->
    <ul id="goalList"></ul>
</div>

<!-- Подключаем JavaScript -->
<?php
$this->registerJsFile('@web/js/goalManager.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
