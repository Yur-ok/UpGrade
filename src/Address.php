<?php

namespace app;

trait Country {
    public function getCountryName()
    {
        return 'Страна: ' . $this->country;
    }
}

trait City {
    public function getCityName()
    {
        return 'Город: ' . $this->city;
    }
}

class Address {
    use Country, City;

    private $country;
    private $city;

    public function __construct($country, $city) {
        $this->country = $country;
        $this->city = $city;
    }

    public function getFullAddress() {
        return $this->getCountryName() . ', ' . $this->getCityName();
    }
}

$address = new Address('Россия', 'Москва');
echo $address->getFullAddress() . PHP_EOL;