<?php


namespace app\tests\unit\models;

use app\models\Goal;
use Codeception\Test\Unit;

class GoalTest extends Unit
{

//    protected UnitTester $tester;
//
//    protected function _before()
//    {
//    }
//
//    // tests
//    public function testSomeFeature()
//    {
//
//    }

    public function testCreateGoal()
    {
        $goal = new Goal();
        $goal->title = 'New GoalManager';
        $goal->description = 'This is a new goal.';

        expect_that($goal->save());
        expect($goal->id)->notNull();
    }
}
