<?php

trait Country
{
    public function getName()
    {
        return 'Страна: ' . $this->country;
    }
}

trait City
{
    public function getName()
    {
        return 'Город: ' . $this->city;
    }
}

class Address
{
    use City, Country{
        City::getName insteadof Country;
        City::getName as getCityName;
        Country::getName as getCountryName;
    }

    private $country;
    private $city;

    public function __construct($country, $city)
    {
        $this->country = $country;
        $this->city = $city;
    }

    public function getFullAddress()
    {
        return $this->getCountryName() . ', ' . $this->getCityName();
    }
}

$address = new Address('Россия', 'Москва');
echo $address->getFullAddress() . PHP_EOL;