<?php
//Есть выражение, заданное строкой, например: y / 5 + (6 - x) * 2 - 1 с ограничениями:
//    • могут быть только символы цифр и '-', '+', '*', '/', '(', ')';
//    • имена переменных состоят из 1-й латинской буквы;
//    • операции не редуцируем (нет такого, что x(2 + y) => x * (2 + y));
//    • нет унарного минуса.
//Вывести значение выражения при заданных значениях переменных.

class EquationSolver
{
    private array $variables;
    private string $equation;
    private float $result = 0;

    public function __construct(string $equation, array $variables)
    {
        $this->equation = $equation;
        $this->variables = $variables;
    }

    public function __invoke(): float|string
    {
        // проверка на то, что уравнение состоит только из допустимых символов
        if (!$this->validateEquation()) {
            return 'Уравнение содержит недопустимые символы';
        }

        // заменяем все переменные их значениями
        $this->variablesSubstitute();

        // разбиваем уравнение на токены
        $tokens = $this->tokenize();

        // вычисляем выражение
        $this->calculate($tokens);

        return $this->result;
    }

    private function validateEquation(): bool
    {
        // проверка на то что уравнение содержить только допустимые символы
        $allowedSymbols = '/^[\s\da-z+\-*\/()]+$/';
        $containAllowedSymbols = preg_match($allowedSymbols, $this->equation) === 1;

        // проверка на то что все переменные состоят из одного символа
        $allowedLength = '/[a-z]{2,}/';
        $containAllowedLength = preg_match($allowedLength, $this->equation) === 1;
        return $containAllowedSymbols && !$containAllowedLength;
    }

    public function variablesSubstitute(): void
    {
        foreach ($this->variables as $key => $variable) {
            $this->equation = str_replace($key, $variable, $this->equation);
        }
    }

    private function tokenize(): array
    {
        // алгоритм сортировочной станции (shunting-yard algorithm)

        $precedence = [
            '+' => 1,
            '-' => 1,
            '*' => 2,
            '/' => 2,
        ];

        $output = [];
        $stack = [];

        $tokensWithSpace = preg_match_all('%\d+|[a-zA-Z]+|[+\-*/()]|\s+%', $this->equation, $matches);

        // убираем пробелы из массива токенов
        $tokens = array_filter($matches[0], static fn($token) => trim($token) !== '');

        foreach ($tokens as $token) {
            if (is_numeric($token) || preg_match('/[a-z]/', $token)) {
                // Если токен число или переменная, добавляем его в выходной список
                $output[] = $token;
            } elseif ($token === '(') {
                // Если токен открывающая скобка, помещаем его в стек
                $stack[] = $token;
            } elseif ($token === ')') {
                // Если токен закрывающая скобка, извлекаем все операторы до открывающей скобки
                while (end($stack) !== '(') {
                    $output[] = array_pop($stack);
                }
                array_pop($stack); // Убираем '(' из стека
            } else {
                // Если токен оператор, учитываем приоритет
                while (!empty($stack) && end($stack) !== '(' && $precedence[end($stack)] >= $precedence[$token]) {
                    $output[] = array_pop($stack);
                }
                $stack[] = $token;
            }
        }

        // Переносим оставшиеся операторы из стека в выходной список
        while (!empty($stack)) {
            $output[] = array_pop($stack);
        }

        return $output;
    }

    private function calculate(array $tokens): void
    {
        $stack = [];

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                // Если токен число, добавляем его в стек
                $stack[] = $token;
            } else {
                // Если токен оператор, извлекаем два операнда из стека
                $b = array_pop($stack);
                $a = array_pop($stack);

                switch ($token) {
                    case '+':
                        $stack[] = $a + $b;
                        break;
                    case '-':
                        $stack[] = $a - $b;
                        break;
                    case '*':
                        $stack[] = $a * $b;
                        break;
                    case '/':
                        $stack[] = $a / $b;
                        break;
                }
            }
        }

        // В итоге в стеке останется только одно значение — результат выражения
        $this->result = array_pop($stack);
    }
}

var_dump((new EquationSolver('y / 5 + (6 - x) * 2 - 1', ['x' => 3, 'y' => 2]))());
var_dump((new EquationSolver('y / 5 + (6 - xt) * 2 - 1', ['x' => 13, 'y' => 2]))()); //error
var_dump((new EquationSolver('y / 5 + (6 - x) * 2 - 1', ['x' => 3, 'y' => 20]))());
var_dump((new EquationSolver('y / 5 + (6 - x) * 2 - 1', ['x' => 3, 'y' => 25]))());
var_dump((new EquationSolver('yx / 5 + (6 - x) * 2 - 1', ['x' => 43, 'y' => 52]))()); //error