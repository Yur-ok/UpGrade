<?php

namespace app\controllers;

class MagicPrivate{}


class User
{
    protected $id;
    protected $name;
    protected $country;
    private $data;

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = 'Private: ' . $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }
}

$u = new User();
$u->test = 'value';
echo $u->test . PHP_EOL;

$u->name = '007';
echo 'name = ' . $u->name . PHP_EOL;

$u->country = 'Russia';
echo 'country = ' . $u->country . PHP_EOL;