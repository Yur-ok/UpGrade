<?php

namespace app\tests\unit\models;

use app\models\Calculator;
use Codeception\Test\Unit;

class CalculatorTest extends Unit
{
    /**
     * @var Calculator
     */
    private $calculator;

    protected function _before()
    {
        $this->calculator = new Calculator();
    }

    public function testAddition()
    {
        $this->assertEquals(5, $this->calculator->add(2, 3));
    }

    public function testSubtraction()
    {
        $this->assertEquals(1, $this->calculator->subtract(3, 2));
    }

    public function testMultiplication()
    {
        $this->assertEquals(6, $this->calculator->multiply(2, 3));
    }

    public function testDivision()
    {
        $this->assertEquals(2, $this->calculator->divide(6, 3));
    }

    public function testDivisionByZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->divide(6, 0);
    }
}
