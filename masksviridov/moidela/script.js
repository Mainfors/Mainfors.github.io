
let tasks = [];

// Получаем элементы страницы
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
        li.textContent = tasks[i] + ' ';

        
        const editBtn = document.createElement('button');
        editBtn.textContent = 'Изменить';
        
        
        editBtn.addEventListener('click', function () {
            // Запрашиваем новое название задачи
            const newTask = prompt('Введите новое название задачи:', tasks[i]);

         
            if (newTask === null) {
                return;
            }

            const trimmedNewTask = newTask.trim();

            // Проверка на пустое значение
            if (trimmedNewTask === '') {
                message.textContent = 'Название задачи не может быть пустым!';
                return;
            }

            if (trimmedNewTask !== tasks[i] && tasks.includes(trimmedNewTask)) {
                message.textContent = 'Такая задача уже есть в списке!';
                return;
            }

            
            tasks[i] = trimmedNewTask;
            
            
            message.textContent = 'Задача успешно изменена.';
            renderTasks();
        });

        li.appendChild(editBtn);
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

// Удаление задачи через splice()
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