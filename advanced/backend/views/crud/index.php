<?php

/** @var yii\web\View $this */

/** @var $countries array */

?>

<div>
    <ul>
        <?php
        foreach ($countries as $item): echo
        <<<ITEM
    <li id="itm-$item[number]">Item $item[name]</li>
ITEM;
        endforeach; ?>
    </ul>
</div>
