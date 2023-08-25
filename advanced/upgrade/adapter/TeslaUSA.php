<?php

namespace upgrade\adapter;

class TeslaUSA implements Speed
{
    public function getSpeed(): int
    {
        return  270;
    }
}