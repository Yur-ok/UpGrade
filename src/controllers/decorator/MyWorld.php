<?php

namespace app\controllers\decorator;

class MyWorld implements MyText
{

    protected MyText $object;


    public function __construct(MyText $text)
    {
        $this->object = $text;
    }


    public function show(): void
    {
        echo 'рулит!' . PHP_EOL;

        $this->object->show();
    }

}
