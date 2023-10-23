<?php

namespace app\controllers\decorator;


class MySpace implements MyText
{

    protected MyText $object;


    public function __construct(MyText $text)
    {
        $this->object = $text;
    }


    public function show(): void
    {
        echo ' ';

        $this->object->show();
    }

}
