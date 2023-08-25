<?php

namespace upgrade\adapter;

interface Speed
{
    //возвращает скорость для США миль/ч

    public function getSpeed(): int;
}