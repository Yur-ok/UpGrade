function evaluateExpression(expression, variables) {
    // Преобразование инфиксного выражения в постфиксное
    function infixToPostfix(exp) {
        const precedence = {'+': 1, '-': 1, '*': 2, '/': 2};
        const output = [];
        const operators = [];

        for (let i = 0; i < exp.length; i++) {
            const char = exp[i];

            if (char >= '0' && char <= '9') {
                let num = '';
                while (i < exp.length && exp[i] >= '0' && exp[i] <= '9') {
                    num += exp[i++];
                }
                output.push(num);
                i--;
            } else if (char === '(') {
                operators.push(char);
            } else if (char === ')') {
                while (operators.length && operators[operators.length - 1] !== '(') {
                    output.push(operators.pop());
                }
                operators.pop();
            } else if (char === '+' || char === '-' || char === '*' || char === '/') {
                while (operators.length && precedence[operators[operators.length - 1]] >= precedence[char]) {
                    output.push(operators.pop());
                }
                operators.push(char);
            }
        }

        while (operators.length) {
            output.push(operators.pop());
        }

        return output;
    }

    // Вычисление значения постфиксного выражения
    function evaluatePostfix(postfix) {
        const stack = [];

        for (let i = 0; i < postfix.length; i++) {
            const token = postfix[i];
            if (token >= '0' && token <= '9') {
                stack.push(parseFloat(token));
            } else {
                const b = stack.pop();
                const a = stack.pop();
                if (token === '+') stack.push(a + b);
                else if (token === '-') stack.push(a - b);
                else if (token === '*') stack.push(a * b);
                else if (token === '/') stack.push(a / b);
            }
        }

        return stack[0];
    }

    // Замена переменных в выражении их значениями
    function replaceVariables(exp, vars) {
        let updatedExpression = exp;
        for (let i = 0; i < vars.length; i++) {
            const varName = vars[i][0];
            const value = vars[i][1];
            const regex = new RegExp('\\b' + varName + '\\b', 'g');
            updatedExpression = updatedExpression.replace(regex, value);
        }
        return updatedExpression;
    }

    // Замена переменных на их значения
    const updatedExpression = replaceVariables(expression, variables);

    // Преобразование в постфиксную форму и вычисление результата
    const postfix = infixToPostfix(updatedExpression);
    return evaluatePostfix(postfix);
}

// Функция для извлечения переменных из выражения
function extractVariables(expression) {
    const variables = [];
    for (let i = 0; i < expression.length; i++) {
        const char = expression[i];
        if (char >= 'a' && char <= 'z') {
            if (variables.indexOf(char) === -1) {
                variables.push(char);
            }
        }
    }
    return variables;
}

// Основная программа
function main() {
    // Запрос уравнения у пользователя
    const expression = prompt("Введите уравнение:");

    // Извлечение переменных из уравнения
    const variableNames = extractVariables(expression);

    // Ввод значений для переменных
    const variables = [];
    for (let i = 0; i < variableNames.length; i++) {
        const varName = variableNames[i];
        const value = prompt("Введите значение для " + varName + ": ");
        variables.push([varName, value]);
    }

    // Вычисление результата
    const result = evaluateExpression(expression, variables);
    console.log("Результат: " + result);
}

// Запуск основной программы
main();