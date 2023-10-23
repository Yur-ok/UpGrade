<?php

include 'serialize.php';

$contents = file_get_contents(__DIR__ . '/userOptions');

$userOptions = unserialize($contents);

var_dump($userOptions);