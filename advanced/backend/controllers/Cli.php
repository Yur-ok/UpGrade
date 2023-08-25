<?php

$redis = new \Redis();
$redis->connect('redis');

$redis->flushAll();

$redis->set('key', 42);
echo $redis->get('key') . PHP_EOL;
echo $redis->getSet('key', 22) . PHP_EOL;
echo $redis->get('key') . PHP_EOL;
$redis->del('key');
var_dump($redis->keys('*'));


$redis->hSet('arr', 'color', 'red');
$redis->hSet('arr', 'size', 42);
var_dump($redis->hGetAll('arr'));

$redis->hSet('arr', 'color', 'yellow');
var_dump($redis->hGetAll('arr'));
