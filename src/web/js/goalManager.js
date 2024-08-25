class Goal {
    constructor(id, title, description) {
        this.id = id;
        this.title = title;
        this.description = description;
    }
}

class GoalManager {
    constructor(baseUrl, token) {
        this.baseUrl = baseUrl;
        this.token = token;
        this.goals = [];
        this.goalListElement = document.getElementById('goalList');
        this.goalTitleInput = document.getElementById('goalTitle');
        this.goalDescriptionInput = document.getElementById('goalDescription');
        this.addGoalButton = document.getElementById('addGoalBtn');

        this.fetchGoals();
        this.initEventListeners();
    }

    initEventListeners() {
        this.addGoalButton.addEventListener('click', () => this.createGoal());
    }

    async fetchGoals() {
        try {
            const response = await fetch(`${this.baseUrl}/goal`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch goals');
            }

            const data = await response.json();
            this.goals = data.map(goal => new Goal(goal.id, goal.title, goal.description));
            this.renderGoals();
        } catch (error) {
            console.error('Error fetching goals:', error);
        }
    }

    async createGoal() {
        const title = this.goalTitleInput.value;
        const description = this.goalDescriptionInput.value;

        if (!title || !description) {
            alert('Please provide both title and description.');
            return;
        }

        try {
            const response = await fetch(`${this.baseUrl}/goal`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title, description })
            });

            if (!response.ok) {
                throw new Error('Failed to create goal');
            }

            const newGoal = await response.json();
            this.goals.push(new Goal(newGoal.id, newGoal.title, newGoal.description));
            this.renderGoals();
            this.clearFormFields();
        } catch (error) {
            console.error('Error creating goal:', error);
        }
    }

    async deleteGoal(goalId) {
        try {
            const response = await fetch(`${this.baseUrl}/goal/${goalId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            });

            if (!response.ok) {
                throw new Error('Failed to delete goal');
            }

            this.goals = this.goals.filter(goal => goal.id !== goalId);
            this.renderGoals();
        } catch (error) {
            console.error('Error deleting goal:', error);
        }
    }

    renderGoals() {
        this.goalListElement.innerHTML = '';

        this.goals.forEach(goal => {
            const goalItem = document.createElement('li');
            goalItem.textContent = `${goal.title}: ${goal.description}`;

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.onclick = () => this.deleteGoal(goal.id);

            goalItem.appendChild(deleteButton);
            this.goalListElement.appendChild(goalItem);
        });
    }

    clearFormFields() {
        this.goalTitleInput.value = '';
        this.goalDescriptionInput.value = '';
    }
}

// Инициализация GoalManager после загрузки страницы
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('token'); // Предполагаем, что токен сохранен в localStorage
    const baseUrl = 'http://test.loc/api'; // Базовый URL для вашего API

    if (!token) {
        console.error('Authorization token is missing.');
        return;
    }

    const goalManager = new GoalManager(baseUrl, token);
});
