//alert("Привет!"); // Всплывающее окно 
// let - переменная 
// const - постоянная

//let nameStuden ='artem'; // строка
//const age = 18; //числовой тип данных
//const bool = true; // логический булевый 1
//const boolFalse = false; // булевый 0

nameStuden = 'dfdfdsfdfsdf';
nameStuden = 12;


//let button = document.getElementById('bytcl'); // эл-нт нахождение по Id
//let burg = document.getElementsByClassName('btn'); // эл-нт по Class
// .textcontent - еуксе эл-нта

// let buttonQuery = document.querySelector('#bytcl');

//let buttonQuery2 = document.querySelector('.btn');
//console.log(buttonQuery);

//buttonQuery.addEventListener('click' , function(){
//    console.log('Кнопку нажали');
  //  buttonQuery.textContent = 'Кнопку нажали!';
//});

let a = 562;
let b = 80;
let c = 60;

//console.log(a+b)
//console.log(a-b)
//console.log(a/b)
//console.log(a**b)
//console.log(a%b)
//console.log(Math.floor(a/b));
//console.log(Math.floor(a/c));
//console.log(a%c);

const age = document.querySelector('#fd');
const hasTicket = document.querySelector('#hj');
const btnCheck = document.querySelector('#gb');
const mes = document.querySelector('#mes');
// age.value значение внутри инпута
// hasTicket.checked - значение true/false в checkbox

btnCheck.addEventListener("click" , () => {
  if (age.value >= 18 && 
  hasTicket.checked == true) {
  mes.textContent= 'Проход разрешен';
} 
else {
  mes.textContent ='Проход запрещен';
}
})
const but = document.querySelector ('#togl');
const togl = document.querySelector('#df');
but.addEventListener("click", () =>{
togl.classList.toggle('colorgf');

})
// && (логическое и) - оба условия true
// || (Или) - одно из условий true
// ! (Не) - переворачвае
// === сравнение значения и тип
// == сравнение только значение


