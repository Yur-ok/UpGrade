<?php

namespace app\commands;

use app\controllers\decorator\MyEmpty;
use app\controllers\decorator\MySpace;
use app\controllers\decorator\MyWorld;
use app\controllers\decorator\TextPresentation;
use yii\console\Controller;

class TextController extends Controller
{
    public function actionRun(): void
    {
        $decorator = new TextPresentation(new MySpace(new MyWorld(new MyEmpty())));
        $decorator->show(); // Sokolov рулит\n
    }
}


