const status = document.querySelector("#status");
const boxes = document.querySelectorAll(".box");
let currentBox = "X";


boxes.forEach((box, index) => {
    box.addEventListener('click', () => {
        box.textContent = currentBox;

        if(currentBox === 'X'){
            currentBox = 'O';
        } else {
            currentBox ='X';
        }

        status.textContent = 'Ходит:' + currentBox;
    }) 
})