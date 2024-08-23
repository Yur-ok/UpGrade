function evaluateExpression(expression, variables) {
    function infixToPostfix(exp) {
        const precedence = {'+': 1, '-': 1, '*': 2, '/': 2};
        const output = [];
        const operators = [];
        let wasOperator = true;

        for (let i = 0; i < exp.length; i++) {
            const char = exp[i];

            if ((char >= '0' && char <= '9') || (char >= 'a' && char <= 'z')) {
                let token = '';
                while (i < exp.length && ((exp[i] >= '0' && exp[i] <= '9') || exp[i] === '.' || (exp[i] >= 'a' && exp[i] <= 'z'))) {
                    token += exp[i++];
                }
                output.push(token);
                i--;
                wasOperator = false;
            } else if (char === '(') {
                operators.push(char);
                wasOperator = true;
            } else if (char === ')') {
                while (operators.length && operators[operators.length - 1] !== '(') {
                    output.push(operators.pop());
                }
                operators.pop();
                wasOperator = false;
            } else if (char === '+' || char === '-' || char === '*' || char === '/') {
                if (char === '-' && wasOperator) {
                    let token = '-';
                    i++;
                    while (i < exp.length && (exp[i] >= '0' && exp[i] <= '9')) {
                        token += exp[i++];
                    }
                    output.push(token);
                    i--;
                    wasOperator = false;
                } else {
                    while (operators.length && precedence[operators[operators.length - 1]] >= precedence[char]) {
                        output.push(operators.pop());
                    }
                    operators.push(char);
                    wasOperator = true;
                }
            }
        }

        while (operators.length) {
            output.push(operators.pop());
        }

        return output;
    }

    function evaluatePostfix(postfix) {
        const stack = [];
        for (let i = 0; i < postfix.length; i++) {
            const token = postfix[i];
            if (!isNaN(token)) {
                stack.push(parseFloat(token));
            } else if (token.length > 1 && token[0] === '-') {
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

    const updatedExpression = replaceVariables(expression, variables);
    const postfix = infixToPostfix(updatedExpression);
    return evaluatePostfix(postfix);
}

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

function main() {
    const expression = prompt("Введите уравнение:");
    const variableNames = extractVariables(expression);
    const variables = [];

    for (let i = 0; i < variableNames.length; i++) {
        const varName = variableNames[i];
        let value;
        do {
            value = prompt("Введите значение для " + varName + ": ");
            if (isNaN(value)) {
                alert("Пожалуйста, введите корректное число для " + varName + ".");
            }
        } while (isNaN(value)); // Повторяем, пока не введет число
        variables.push([varName, value]);
    }

    const result = evaluateExpression(expression, variables);
    console.log("Результат: " + result);
}

main();
