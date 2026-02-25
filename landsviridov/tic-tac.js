const status = document.querySelector("#status");
const boxes = document.querySelectorAll(".box");
let currentBox = "X";

const WinComb = [
    [0,1,2],
    [3,4,5],
    [6,7,8],
    [0,3,6],
    [1,4,7],
    [2,5,8],
    [0,4,8],
    [2,4,6]
];

boxes.forEach((box, index) => {
    box.addEventListener('click', () => {
        
        if(box.textContent !== '') return;    

        box.textContent = currentBox;

        for(let comb of WinComb){
            let[a,b,c] = comb
            
            if(boxes[a].textContent ==  boxes[b].textContent && boxes[b].textContent == boxes[c].textContent && boxes[a].textContent !== "" ){
               status.textContent = 'Победа:' + currentBox;
               return;
            }

        }
        


        if(box.textContent == 'X'){
            box.classList.add("x");
        } else{
            box.classList.add("O");
        }

        if(currentBox === 'X'){
            currentBox = 'O';
        } else {
            currentBox ='X';
        }

        status.textContent = 'Ходит:' + currentBox;
    }) 
})