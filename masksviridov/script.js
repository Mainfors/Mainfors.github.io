// // Задача 1
// let total = 4500;
// let quantity = 4;
// let  registered = true;

// if (total >= 3000 && quantity >= 3 && registered){
//     let finalprice = total * 0.85
//     console.log("Все условия выполнены и вам даю скидку красавчик")
//     console.log("Заплати брат:" + finalprice + "руб");

// } else{
//     console.log("Братптишка ты без скидки условия сделай по красоте")
//     console.log("Братан по красоте не делаешь плати" + total + "руб"); 
// }
// // Задача 2
// let total = 3200;
// let premium = true;
// let delivery = 400;

// let finalpricec;

// if(total >=5000 || premium) {
// finalpricec = total; 
// console.log("Доставка бесплатная");
// } else{ 
//     finalpricec = total + delivery;
//     console.log("Доставка плати")
//  }

//  console.log("Итоговя стоимость -" + finalpricec + "руб");
// // Задача 3
//  let Active = true;
//  let Blocked = false;
//  let Errors = false;

//  if(Active && !Blocked && !Errors){
//     console.log("Заявка отправлена");
//  } else {
//     console.log("Запрещена отправка")
//  }
// // Задача 4
//  let age = 18;
//  let register = true;
//  let block = false;
//  let role = "student";
//  let testfinish = false;

//  if(
//     age >= 16 &&
//     register && !block && (role === "student" || role === "admin") && !testfinish
//  ) {
//     console.log("Можете тестироваться")
//  } else {
//     console.log("Не выполнены условия Ишак")
//  }




//  // циклы

//  for (let i = 1; <= 100; i++){
// console.log(i); 
//  }

//  // Задача
//  function validatePassword(password){
//    if(password.length < 8){
//       return false;
//    }

//    let Chifra = false;
//    let Zaglav = false;

//    for (let i = 0; i < password.length; i++){
//       let charCode = password.charCodeAt(i);
//       if (charCode >= 48 && charCode <= 57){
//          Chifra = true;
//       } 
//       if(charCode >= 65 && charCode <=90){
//          Zaglav = true;
//       }
//       if(Chifra && Zaglav){
//          break;
//       }
//    }
//    return Chifra && Zaglav;
//  }
 
//  console.log(validatePassword("password123"));
//  console.log(validatePassword("Password"));
//  console.log(validatePassword("Kruto34"));
//  console.log(validatePassword("Perchiki178"));
 

 // Задача с налогом
function addCount(price, nalog){
   return price * (1+ nalog / 100);
}

//function formatRubles(value) {
  // return 'Итоговая цена: ${value} руб.';
//}


//function calculate (a, b , func){
//   return func(a, b);
//}

// function sum(first, second){
//    return first + second; 
// }

// function diff(first, second){
//    return first - second; 
// }

// function pow(first, second){
//    return first ** second; 
// }

// function mult(first, second){
//    return first * second; 
// }

// function del(first, second){
//    return first / second; 
// }


// массивы
let grades = [5, 4, 3, 2];
let task = [];
// добавление эл-та
task[0] = "Сделать задание";
task.push("Пропылесосить", "Помыть полы");
//длина массива
console.log(task.length);
console.log(task[task.length - 1]); // последний элемент

const nums = [4, 7, 10];
for (let i = 0; i < nums.length; i++){
   console.log(i, nums[i]);
}

// for..of
const names = ["Оля", "Илья", "Анастасия"];
for(const name of names){
   console.log("Привет" + name);
}

// Задача массив
