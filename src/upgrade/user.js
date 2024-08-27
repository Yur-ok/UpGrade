class User {
    constructor(name, surname) {
        this.name = name;
        this.surname = surname;
    }

    getFullName() {
        return this.name + ' ' + this.surname;
    }
}

class Employee extends User {
    static allowedPositions = ['программер', 'руководитель'];

    #position;
    #salary;

    constructor(name, surname, position, salary) {
        super(name, surname);
        this.setPosition(position);
        this.setSalary(salary);
    }

    getPosition() {
        return this.#position;
    }

    setPosition(position) {
        if (Employee.allowedPositions.includes(position.toLowerCase())) {
            this.#position = position;
        } else {
            throw new Error(`Invalid position: ${position}. Allowed positions are: ${Employee.allowedPositions.join(', ')}.`);
        }
    }

    getSalary() {
        return this.#salary;
    }

    setSalary(salary) {
        if (salary >= 0) {
            this.#salary = salary;
        } else {
            throw new Error('Salary cannot be negative.');
        }
    }
}

try {
    const employee = new Employee('Иван', 'Иванов', 'программер', 500000);
    console.log(employee.getFullName());
    console.log(employee.getPosition());
    console.log(employee.getSalary());

    employee.setPosition('руководитель');
    console.log(employee.getPosition());

    employee.setSalary(600000);
    console.log(employee.getSalary());

    // Примеры ошибок
    employee.setSalary(-1000);
    employee.setPosition('дизайнер');
} catch (error) {
    console.error(error.message);
}
