document.addEventListener('DOMContentLoaded', () => {
    const calcBtn = document.getElementById('calcBtn');
    const resultDiv = document.getElementById('result');

    calcBtn.addEventListener('click', () => {
        const kInput = document.getElementById('kInput').value.trim();
        const seqInput = document.getElementById('seqInput').value.trim();

        // Сброс стилей перед новым выводом
        resultDiv.classList.remove('success', 'error');

        // Проверка на корректность ввода K
        if (kInput === '' || isNaN(kInput)) {
            resultDiv.textContent = 'Ошибка: Введите корректное целое число K!';
            resultDiv.classList.add('error');
            return;
        }

        const K = parseInt(kInput, 10);

        // Если последовательность пустая
        if (seqInput === '') {
            resultDiv.textContent = 'Результат: 0 (последовательность пуста)';
            resultDiv.classList.add('success');
            return;
        }

        // Разбиваем строку на числа (по пробелам, запятым или другим разделителям)
        const numbers = seqInput.split(/[\s,]+/).map(Number);

        let position = 0; // Счетчик позиции ненулевых чисел
        let found = false;

        for (let i = 0; i < numbers.length; i++) {
            const currentNum = numbers[i];

            // Если встретили 0 — завершаем цикл (признак окончания)
            if (currentNum === 0) {
                break;
            }

            // Проверяем, является ли число корректным
            if (isNaN(currentNum)) {
                resultDiv.textContent = 'Ошибка: В последовательности есть некорректные символы!';
                resultDiv.classList.add('error');
                return;
            }

            position++; // Увеличиваем номер позиции для ненулевого числа

            // Если число больше K — выводим его номер и завершаем
            if (currentNum > K) {
                resultDiv.textContent = `Результат: ${position}`;
                resultDiv.classList.add('success');
                found = true;
                break;
            }
        }

        // Если число не найдено
        if (!found) {
            resultDiv.textContent = 'Результат: 0';
            resultDiv.classList.add('success');
        }
    });
});