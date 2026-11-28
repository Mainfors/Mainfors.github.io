// Тема 1. Задание 1
let status = "processing";
let userRole = "owner";
let isShipped = false;

if (userRole === "guest") {
    console.log("У вас нет доступа к этому заказу");
} else if (status === "completed") {
    console.log("Ваш заказ завершен");
} else {
    let statusOk = (status === "new" || status === "processing");
    let roleOk = (userRole === "owner" || userRole === "admin");
    let shippedOk = !isShipped;
    let adminCanCancelShipped = (userRole === "admin" && isShipped);

    if (statusOk && roleOk && (shippedOk || adminCanCancelShipped)) {
        console.log("Отмена заказа разрешена");
    } else {
        console.log("Отмена заказа запрещена");
    }
}

// Тема 2. Задание 2.1
for (let i = 1; i <= 30; i++) {
    if (i % 3 === 0) {
        console.log(i);
    }
}

// Тема 2. Задание 2.2
let total = 0;
for (let i = 1; i <= 6; i++) {
    total += 250;
    console.log(`После добавления товара №${i} сумма: ${total} руб.`);
}
console.log(`Итоговая стоимость: ${total} руб.`);

// Тема 2. Задание 2.3
let evenCount = 0;
let oddCount = 0;

for (let i = 1; i <= 25; i++) {
    if (i % 2 === 0) {
        evenCount++;
    } else {
        oddCount++;
    }
}

console.log(`Чётных: ${evenCount}`);
console.log(`Нечётных: ${oddCount}`);

// Тема 2. Задание 2.4
for (let orderNum = 1; orderNum <= 10; orderNum++) {
    if (orderNum === 3 || orderNum === 6) {
        console.log(`Заказ № ${orderNum} отменён`);
        continue;
    }
    if (orderNum === 8) {
        break;
    }
    console.log(`Заказ № ${orderNum} обработан`);
}

// Тема 2. Задание 2.5
const correctPin = "2468";
let attempts = 0;
let success = false;

while (attempts < 3) {
    let input = prompt("Введите PIN-код:");
    attempts++;

    if (input === correctPin) {
        success = true;
        console.log("Код верный");
        break;
    }
}

if (!success) {
    console.log("Попытки закончились");
}

// Тема 2. Задание 2.6
let number = 29;
let isPrime = true;

if (number <= 1) {
    isPrime = false;
} else {
    for (let i = 2; i <= Math.sqrt(number); i++) {
        if (number % i === 0) {
            isPrime = false;
            break;
        }
    }
}

console.log(isPrime ? `${number} — простое число` : `${number} — не простое число`);

// Тема 3. Задание 3.1
function checkAge(age) {
    if (age < 18) {
        return "Доступ запрещён";
    }
    return "Доступ разрешён";
}

console.log(checkAge(15));
console.log(checkAge(18));
console.log(checkAge(25));
console.log(checkAge(10));

// Тема 3. Задание 3.2
function calculateDiscount(price, discount) {
    if (discount < 0 || discount > 50) {
        return "Некорректная скидка";
    }
    let discountAmount = price * (discount / 100);
    return price - discountAmount;
}

console.log(calculateDiscount(4000, 15));
console.log(calculateDiscount(4000, 60));
console.log(calculateDiscount(4000, -5));

// Тема 3. Задание 3.3
function countEven(start, end) {
    let count = 0;
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            count++;
        }
    }
    return count;
}

console.log(countEven(1, 10));
console.log(countEven(1, 25));

// Тема 3. Задание 3.4
function validatePassword(password) {
    if (password.length < 8) {
        return false;
    }

    let hasDigit = false;
    let hasUppercase = false;

    for (let i = 0; i < password.length; i++) {
        let char = password[i];
        if (char >= "0" && char <= "9") {
            hasDigit = true;
        }
        if (char >= "A" && char <= "Z") {
            hasUppercase = true;
        }
    }

    return hasDigit && hasUppercase;
}

console.log(validatePassword("Password1"));
console.log(validatePassword("password1"));
console.log(validatePassword("Password"));
console.log(validatePassword("Pass1"));

// Тема 3. Задание 3.5
function formalGreeting(name) {
    return `Здравствуйте, ${name}!`;
}

function friendlyGreeting(name) {
    return `Привет, ${name}!`;
}

function createMessage(name, callback) {
    return callback(name);
}

console.log(createMessage("Анна", formalGreeting));
console.log(createMessage("Анна", friendlyGreeting));

// Тема 3. Задание 3.6
function applyDiscount(total) {
    return total * 0.85;
}

function addDelivery(total) {
    return total + 350;
}

function processOrder(total, operation) {
    return operation(total);
}

console.log(processOrder(4000, applyDiscount));
console.log(processOrder(1000, addDelivery));

// Тема 3. Задание 3.7
function addDelivery(price) {
    return price + 350;
}

function applyDiscount(price) {
    return price * 0.9;
}

function processOrder(price, deliveryFunc, discountFunc) {
    if (price < 3000) {
        return deliveryFunc(price);
    } else {
        return discountFunc(price);
    }
}

let price = Number(prompt("Введите стоимость заказа:"));

if (isNaN(price) || price < 0) {
    console.log("Некорректная стоимость");
} else {
    let result = processOrder(price, addDelivery, applyDiscount);
    console.log(`Итоговая стоимость: ${result} руб.`);
}

// Тема 4. Задание 4.1
let orders = [450, 1200, 850, 3000, 1750, 600, 4200];

let largeOrders = orders.filter(order => order >= 1000);
console.log("Заказы от 1000 руб.:", largeOrders);

let discountedPrices = largeOrders.map(order => order * 0.9);
console.log("Крупные заказы со скидкой 10%:", discountedPrices);

let firstExpensive = orders.find(order => order > 2500);
console.log("Первый заказ дороже 2500 руб.:", firstExpensive);

let cheapIndex = orders.findIndex(order => order < 700);
console.log("Индекс первого заказа дешевле 700 руб.:", cheapIndex);

let index850 = orders.findIndex(order => order === 850);
if (index850 !== -1) {
    orders.splice(index850, 1);
}
console.log("Массив после удаления заказа на 850 руб.:", orders);

orders.forEach((order, index) => {
    console.log(`Заказ №${index + 1}: ${order} руб.`);
});