<?php

class SequentialExecutor {

    private function stepOne() {
        echo "Выполнение шага 1\n";
    }

    private function stepTwo() {
        echo "Выполнение шага 2\n";
    }

    private function stepThree() {
        echo "Выполнение шага 3\n";
    }

    public function executeAllPrivateMethods() {
        $reflectionClass = new ReflectionClass($this);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PRIVATE);

        foreach ($methods as $method) {
            $method->invoke($this);
        }
    }
}