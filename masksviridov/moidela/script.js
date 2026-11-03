
let tasks = [];


const taskInput = document.getElementById('taskInput');
const addBtn = document.getElementById('addBtn');
const findBtn = document.getElementById('findBtn');
const removeBtn = document.getElementById('removeBtn');
const taskList = document.getElementById('taskList');
const message = document.getElementById('message');


function renderTasks() {
    taskList.innerHTML = '';
    for (let i = 0; i < tasks.length; i++) {
        const li = document.createElement('li');
        li.textContent = tasks[i];
        taskList.appendChild(li);
    }
}


function clearInput() {
    taskInput.value = '';
    message.textContent = '';
}


addBtn.addEventListener('click', function () {
    const task = taskInput.value.trim();

    if (task === '') {
        message.textContent = 'Введите задачу!';
        return;
    }

    if (tasks.includes(task)) {
        message.textContent = 'Такая задача уже есть в списке!';
        return;
    }

    tasks.push(task);
    renderTasks();
    clearInput();
});


findBtn.addEventListener('click', function () {
    const task = taskInput.value.trim();

    if (task === '') {
        message.textContent = 'Введите задачу для поиска!';
        return;
    }

    const index = tasks.indexOf(task);

    if (index === -1) {
        message.textContent = 'Задача не найдена!';
    } else {
        message.textContent = 'Задача найдена, позиция: ' + (index + 1);
    }
});


removeBtn.addEventListener('click', function () {
    const task = taskInput.value.trim();

    if (task === '') {
        message.textContent = 'Введите задачу для удаления!';
        return;
    }

    const index = tasks.indexOf(task);

    if (index === -1) {
        message.textContent = 'Такой задачи нет в списке!';
    } else {
        tasks.splice(index, 1);
        renderTasks();
        message.textContent = 'Задача удалена.';
        taskInput.value = '';
    }
});