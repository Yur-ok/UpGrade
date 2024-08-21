// Функция для вычисления выражения
function evaluateExpression(expression, variables) {
    // Преобразование инфиксного выражения в постфиксное
    function infixToPostfix(exp) {
        const precedence = { '+': 1, '-': 1, '*': 2, '/': 2 };
        const output = [];
        const operators = [];

        for (let i = 0; i < exp.length; i++) {
            const char = exp[i];

            if (/\d/.test(char)) {
                let num = '';
                while (i < exp.length && /\d/.test(exp[i])) {
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
            } else if ('+-*/'.includes(char)) {
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

        postfix.forEach(token => {
            if (/\d/.test(token)) {
                stack.push(Number(token));
            } else {
                const b = stack.pop();
                const a = stack.pop();
                switch (token) {
                    case '+': stack.push(a + b); break;
                    case '-': stack.push(a - b); break;
                    case '*': stack.push(a * b); break;
                    case '/': stack.push(a / b); break;
                }
            }
        });

        return stack[0];
    }

    // Замена переменных в выражении их значениями
    function replaceVariables(exp, vars) {
        let updatedExpression = exp;
        for (const [varName, value] of Object.entries(vars)) {
            const regex = new RegExp(`\\b${varName}\\b`, 'g');
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

console.log("Результат:", evaluateExpression("y / 5 + (6 - x) * 2 - 1", {x: 3, y: 10}));
console.log("Результат:", evaluateExpression("y / 5 + (6 - x) * 2 - 1", {x: 2, y: 410}));
console.log("Результат:", evaluateExpression("y / 5 + (6 - x) * 2 - 1", {x: 1, y: 130}));
console.log("Результат:", evaluateExpression("yy / 5 + (6 - x) * 2 - 1", {x: 3, y: 10})); //NaN
