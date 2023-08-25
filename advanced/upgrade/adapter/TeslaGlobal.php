<?php

namespace upgrade\adapter;

class TeslaGlobal implements SpeedAdapter
{

    private TeslaUSA $tesla;

    public function __construct(TeslaUSA $tesla)
    {
        $this->tesla = $tesla;
    }

    public function getSpeed(): int
    {
        return $this->convertMPHtoKMPH($this->tesla->getSpeed());
    }

    private function convertMPHtoKMPH(int $mph): float
    {
        return $mph * 1.60934;
    }
}