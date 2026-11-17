// Исходный массив книг
let books = [
    { id: 1, title: "Мастер и Маргарита", author: "Михаил Булгаков", year: 1967, available: true },
    { id: 2, title: "Преступление и наказание", author: "Фёдор Достоевский", year: 1866, available: false },
    { id: 3, title: "Евгений Онегин", author: "Александр Пушкин", year: 1833, available: true }
];

// Следующий id для новой книги
let nextId = 4;

// Текущий режим отображения: "all" | "available" | "search"
let viewMode = "all";
let searchQuery = "";

// === Ссылки на DOM-элементы ===
const booksListEl = document.getElementById("books-list");
const totalCountEl = document.getElementById("total-count");
const availableCountEl = document.getElementById("available-count");

const addForm = document.getElementById("add-form");
const titleInput = document.getElementById("title");
const authorInput = document.getElementById("author");
const yearInput = document.getElementById("year");
const formMessage = document.getElementById("form-message");

const searchInput = document.getElementById("search-input");
const searchBtn = document.getElementById("search-btn");
const resetSearchBtn = document.getElementById("reset-search-btn");
const searchMessage = document.getElementById("search-message");

const filterAvailableBtn = document.getElementById("filter-available-btn");
const showAllBtn = document.getElementById("show-all-btn");

// === Получение книг для отображения ===
function getVisibleBooks() {
    if (viewMode === "available") {
        return books.filter(book => book.available);
    }
    if (viewMode === "search") {
        const found = books.find(book =>
            book.title.toLowerCase().includes(searchQuery.toLowerCase())
        );
        return found ? [found] : [];
    }
    return books;
}

// === Отрисовка списка книг ===
function renderBooks() {
    booksListEl.innerHTML = "";

    const visible = getVisibleBooks();

    if (visible.length === 0) {
        const empty = document.createElement("p");
        empty.className = "empty";
        empty.textContent = "Книг для отображения нет.";
        booksListEl.appendChild(empty);
        return;
    }

    visible.forEach(book => {
        const card = document.createElement("div");
        card.className = "card";

        // Информация о книге
        const info = document.createElement("div");
        info.className = "info";

        const titleEl = document.createElement("div");
        titleEl.className = "title";
        titleEl.textContent = book.title;
        info.appendChild(titleEl);

        const metaEl = document.createElement("div");
        metaEl.className = "meta";
        metaEl.textContent = `${book.author}, ${book.year} г.`;
        info.appendChild(metaEl);

        const statusEl = document.createElement("span");
        statusEl.className = "status " + (book.available ? "avail" : "issued");
        statusEl.textContent = book.available ? "В наличии" : "Выдана";
        info.appendChild(statusEl);

        card.appendChild(info);

        // Кнопки управления
        const actions = document.createElement("div");
        actions.className = "actions";

        const toggleBtn = document.createElement("button");
        toggleBtn.className = "btn small";
        toggleBtn.textContent = book.available ? "Выдать" : "Вернуть";
        toggleBtn.addEventListener("click", () => toggleAvailability(book.id));
        actions.appendChild(toggleBtn);

        const deleteBtn = document.createElement("button");
        deleteBtn.className = "btn small danger";
        deleteBtn.textContent = "Удалить";
        deleteBtn.addEventListener("click", () => deleteBook(book.id));
        actions.appendChild(deleteBtn);

        card.appendChild(actions);
        booksListEl.appendChild(card);
    });
}

// === Обновление статистики ===
function updateStats() {
    const total = books.length;
    const available = books.filter(book => book.available).length;
    totalCountEl.textContent = total;
    availableCountEl.textContent = available;
}

// === Полное обновление интерфейса ===
function refresh() {
    renderBooks();
    updateStats();
}

// === Добавление книги ===
addForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const title = titleInput.value.trim();
    const author = authorInput.value.trim();
    const yearStr = yearInput.value.trim();

    if (!title || !author) {
        showFormMessage("Заполните название и автора книги.", false);
        return;
    }

    const year = Number(yearStr);
    const currentYear = new Date().getFullYear();
    if (!yearStr || !Number.isInteger(year) || year < 1000 || year > currentYear) {
        showFormMessage(`Введите корректный год (от 1000 до ${currentYear}).`, false);
        return;
    }

    const newBook = {
        id: nextId++,
        title: title,
        author: author,
        year: year,
        available: true
    };

    books.push(newBook);

    addForm.reset();
    showFormMessage(`Книга «${newBook.title}» добавлена.`, true);

    viewMode = "all";
    searchQuery = "";
    searchMessage.textContent = "";
    searchInput.value = "";

    refresh();
});

function showFormMessage(text, success) {
    formMessage.textContent = text;
    formMessage.className = "message" + (success ? " success" : "");
}

// === Поиск книги по названию ===
searchBtn.addEventListener("click", () => {
    const query = searchInput.value.trim();
    if (!query) {
        searchMessage.textContent = "Введите название для поиска.";
        return;
    }
    searchQuery = query;
    viewMode = "search";

    const found = books.find(book =>
        book.title.toLowerCase().includes(query.toLowerCase())
    );
    searchMessage.textContent = found
        ? `Найдена книга: «${found.title}».`
        : `Книга по запросу «${query}» не найдена.`;

    renderBooks();
});

// Сброс поиска
resetSearchBtn.addEventListener("click", () => {
    searchInput.value = "";
    searchQuery = "";
    searchMessage.textContent = "";
    viewMode = "all";
    renderBooks();
});

// === Фильтрация: только в наличии ===
filterAvailableBtn.addEventListener("click", () => {
    viewMode = "available";
    searchMessage.textContent = "";
    renderBooks();
});

// Возврат к полному списку
showAllBtn.addEventListener("click", () => {
    viewMode = "all";
    searchMessage.textContent = "";
    renderBooks();
});

//  Выдача / возврат книги 
function toggleAvailability(id) {
    const book = books.find(b => b.id === id);
    if (!book) return;
    book.available = !book.available;
    refresh();
}

// === Удаление книги ===
function deleteBook(id) {
    const index = books.findIndex(b => b.id === id);
    if (index === -1) {
        return;
    }
    books.splice(index, 1);

    if (viewMode === "search") {
        const stillFound = books.find(book =>
            book.title.toLowerCase().includes(searchQuery.toLowerCase())
        );
        if (!stillFound) {
            searchMessage.textContent = "Найденная книга была удалена.";
        }
    }

    refresh();
}

//  Первоначальный рендер
refresh();