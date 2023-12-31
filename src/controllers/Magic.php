<?php

namespace app\controllers;

class Magic
{
}


class User
{
    protected $id;
    protected $name;
    protected $country;

    public function __call($name, $arguments)
    {
        if (!property_exists($this, $name)) {
            throw new \BadMethodCallException();
        }

        return $this->$name->getName() . PHP_EOL;
    }

    public function __isset($property)
    {
        return isset($this->$property);
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function __get($property)
    {
        return $this->$property;
    }
}

class Country
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

$u = new User();
$u->country = new Country('Russia');
echo $u->country();
