<?php

namespace app\controllers\decorator;


class TextPresentation implements MyText
{

    protected MyText $object;


    public function __construct(MyText $text)
    {
        $this->object = $text;
    }


    public function show(): void
    {
        echo 'Sokolov';

        $this->object->show();
    }

}
