<?php

namespace upgrade\adapter;

interface SpeedAdapter
{
    // возвращает скорость км\ч

    public function getSpeed(): int;
}