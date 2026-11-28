const STORAGE_KEY = "deadlinePlanner.tasks.v1";
const $ = (selector) => document.querySelector(selector);
const form = $("#task-form");
const titleInput = $("#title");
const subjectInput = $("#subject");
const dateInput = $("#due-date");
const priorityInput = $("#priority");
const errorBox = $("#form-error");
const searchInput = $("#search");
let tasks = loadTasks();
let currentFilter = "all";
let editingId = null;

function loadTasks() {
  try {
    const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
    return Array.isArray(saved) ? saved.filter(t => t && t.id && t.title && t.dueDate) : [];
  } catch { return []; }
}

function saveTasks() { localStorage.setItem(STORAGE_KEY, JSON.stringify(tasks)); }


function localDateISO(date = new Date()) {
  const y = date.getFullYear(), m = String(date.getMonth()+1).padStart(2,"0"), d = String(date.getDate()).padStart(2,"0");
  return `${y}-${m}-${d}`;
}


function parseLocalDate(value) {
  const [y,m,d] = value.split("-").map(Number);
  return new Date(y, m-1, d, 12, 0, 0, 0);
}


function dayDelta(dateString) {
  const today = parseLocalDate(localDateISO());
  const due = parseLocalDate(dateString);
  return Math.round((due - today) / 86400000);
}


function validISODate(value) {
  if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) return false;
  const d = parseLocalDate(value);
  return localDateISO(d) === value;
}


function escapeHTML(value) {
  return String(value).replace(/[&<>"']/g, ch => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[ch]));
}


function formatDate(value) {
  return parseLocalDate(value).toLocaleDateString("ru-RU", {day:"numeric", month:"long", year:"numeric"});
}


function daysLabel(delta) {
  if (delta < 0) return `Просрочено на ${Math.abs(delta)} дн.`;
  if (delta === 0) return "Сдать сегодня · 0 дней";
  if (delta === 1) return "Остался 1 день";
  return `Осталось ${delta} дн.`;
}


function priorityLabel(value) {
  return ({low:"Низкий", medium:"Средний", high:"Высокий"})[value] || "Средний";
}


function visibleByFilter(task) {
  if (currentFilter === "active") return !task.completed;
  if (currentFilter === "done") return task.completed;
  return true;
}


function makeCard(task) {
  const delta = dayDelta(task.dueDate);
  const statusClass = task.completed ? "completed" : delta < 0 ? "overdue" : delta <= 2 ? "soon" : "";
  const dueText = task.completed
    ? `Сдано ${formatDate(task.completedAt)}`
    : `${formatDate(task.dueDate)} · ${daysLabel(delta)}`;
  const actions = task.completed
    ? `<button class="small-button" data-action="edit" data-id="${task.id}">Изменить</button><button class="small-button" data-action="delete" data-id="${task.id}">Удалить</button>`
    : `<button class="small-button done-action" data-action="done" data-id="${task.id}">Сдано</button><button class="small-button" data-action="edit" data-id="${task.id}">Изменить</button><button class="small-button" data-action="delete" data-id="${task.id}">Удалить</button>`;
  return `<article class="task-card ${statusClass}">
    <div class="task-main">
      <p class="task-title">${escapeHTML(task.title)}</p>
      <div class="task-meta"><span>${escapeHTML(task.subject)}</span><span class="priority">Приоритет: ${priorityLabel(task.priority)}</span></div>
    </div>
    <div class="due">${dueText}</div>
    <div class="task-actions">${actions}</div>
  </article>`;
}


function render() {
  const query = searchInput.value.trim().toLocaleLowerCase("ru");
  const filtered = tasks.filter(t => visibleByFilter(t) && t.title.toLocaleLowerCase("ru").includes(query));
  const active = filtered.filter(t => !t.completed);
  const done = filtered.filter(t => t.completed).sort((a,b) => (b.completedAt || "").localeCompare(a.completedAt || ""));
  const groups = {
    overdue: active.filter(t => dayDelta(t.dueDate) < 0).sort((a,b) => a.dueDate.localeCompare(b.dueDate)),
    week: active.filter(t => dayDelta(t.dueDate) >= 0 && dayDelta(t.dueDate) <= 7).sort((a,b) => a.dueDate.localeCompare(b.dueDate)),
    later: active.filter(t => dayDelta(t.dueDate) > 7).sort((a,b) => a.dueDate.localeCompare(b.dueDate)),
    done
  };
  const ids = {overdue:"overdue-list", week:"week-list", later:"later-list", done:"done-list"};
  const sections = {overdue:"overdue-section", week:"week-section", later:"later-section", done:"done-section"};
  const counts = {overdue:"overdue-count", week:"week-count", later:"later-count", done:"history-count"};
  Object.keys(groups).forEach(key => {
    const list = $("#"+ids[key]);
    list.innerHTML = groups[key].map(makeCard).join("");
    $("#"+counts[key]).textContent = groups[key].length;
    $("#"+sections[key]).classList.toggle("hidden", groups[key].length === 0);
  });
  $("#active-count").textContent = tasks.filter(t => !t.completed).length;
  $("#done-count").textContent = tasks.filter(t => t.completed).length;
  $("#empty-state").classList.toggle("hidden", filtered.length !== 0);
}


function resetForm() {
  form.reset(); editingId = null; errorBox.textContent = "";
  $("#form-heading").textContent = "Добавить задачу";
  $("#submit-button").textContent = "Добавить задачу";
  $("#cancel-edit").classList.add("hidden");
}


form.addEventListener("submit", event => {
  event.preventDefault();
  const title = titleInput.value.trim(), subject = subjectInput.value.trim(), dueDate = dateInput.value;
  if (!title || !subject) { errorBox.textContent = "Заполните название задачи и предмет."; return; }
  if (!validISODate(dueDate)) { errorBox.textContent = "Укажите корректную дату сдачи."; return; }
  const data = {title, subject, dueDate, priority: priorityInput.value};
  if (editingId) {
    const item = tasks.find(t => t.id === editingId);
    if (item) Object.assign(item, data);
  } else {
    tasks.push({id: (crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random()), ...data, completed:false, createdAt:localDateISO()});
  }
  saveTasks(); resetForm(); render();
});
$("#cancel-edit").addEventListener("click", resetForm);
$("#task-groups").addEventListener("click", event => {
  const button = event.target.closest("button[data-action]");
  if (!button) return;
  const task = tasks.find(t => t.id === button.dataset.id);
  if (!task) return;
  const action = button.dataset.action;
  if (action === "done") {
    task.completed = true; task.completedAt = localDateISO();
  } else if (action === "edit") {
    editingId = task.id;
    titleInput.value = task.title; subjectInput.value = task.subject;
    dateInput.value = task.dueDate; priorityInput.value = task.priority || "medium";
    $("#form-heading").textContent = "Редактировать задачу";
    $("#submit-button").textContent = "Сохранить изменения";
    $("#cancel-edit").classList.remove("hidden");
    titleInput.focus(); window.scrollTo({top:0, behavior:"smooth"});
  } else if (action === "delete") {
    if (!confirm(`Удалить задачу «${task.title}»?`)) return;
    tasks = tasks.filter(t => t.id !== task.id);
    if (editingId === task.id) resetForm();
  }
  saveTasks(); render();
});
searchInput.addEventListener("input", render);
document.querySelector(".filters").addEventListener("click", event => {
  const button = event.target.closest("[data-filter]");
  if (!button) return;
  currentFilter = button.dataset.filter;
  document.querySelectorAll(".filter").forEach(el => el.classList.toggle("active", el === button));
  render();
});
render();
