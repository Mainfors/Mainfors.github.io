const input = document.getElementById("#taskInput");
const button = document.getElementById("#addButton");
const list = document.getElementById("#taskList");

function addTask(){
    const taskText = input.value.trim();
    
    if (taskText !== ''){
        const li = document.createElement("li");
        li.textContent = taskText;
        list.appendChild(li);
        input.value = '';
    }
}

button.addEventListener("click", addTask);
input.addEventListener("keypress", function(event){
    if (event.key === "Enter"){
        addTask();
    }
});