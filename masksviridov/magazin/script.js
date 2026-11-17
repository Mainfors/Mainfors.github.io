let orders = [450, 1200, 850, 3000, 1750, 600, 4200];
let output = document.getElementById("output");
let log = (text) => { output.textContent += text + "\n"; };

let bigOrders = orders.filter(order => order >= 1000);
log("1. Заказы от 1000 руб.: " + bigOrders.join(", "));

let discountedOrders = orders
  .filter(order => order >= 1500)
  .map(order => order * 0.9);
log("2. Заказы со скидкой 10%: " + discountedOrders.join(", "));

let index2500 = orders.indexOf(2500);
log("3. Индекс заказа за 2500 руб.: " + index2500);

let index850 = orders.indexOf(850);
if (index850 !== -1) {
  orders.splice(index850, 1);
  log("4. Заказ за 850 руб. удалён.");
} else {
  log("4. Заказ за 850 руб. не найден.");
}

log("5. Оставшиеся заказы:");
orders.forEach((order, i) => {
  log(`Заказ №${i + 1}: ${order} руб.`);
});