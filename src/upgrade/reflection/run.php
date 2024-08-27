<?php

require_once 'Factory.php';
require_once 'SequentialExecutor.php';

try {
    $executor = Factory::createObjectFromClassName('SequentialExecutor');
    echo 'Создание объекта: '. get_class($executor). "\n";

    echo 'Начинаем выполнение методов:' . "\n";
    $executor->executeAllPrivateMethods();
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}
