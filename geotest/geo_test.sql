SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `geo_test`
--
CREATE DATABASE IF NOT EXISTS `geo_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `geo_test`;

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer_text` varchar(255) NOT NULL,
  `score` int NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `score`) VALUES
-- Вопрос 1 (Столица Франции)
(1, 1, 'Париж', 10),
(2, 1, 'Лион', 0),
(3, 1, 'Марсель', 0),
-- Вопрос 2 (Столица Японии)
(4, 2, 'Токио', 10),
(5, 2, 'Осака', 0),
(6, 2, 'Киото', 0),
-- Вопрос 3 (Столица Канады)
(7, 3, 'Оттава', 10),
(8, 3, 'Торонто', 0),
(9, 3, 'Ванкувер', 0),
-- Вопрос 4 (Столица Австралии)
(10, 4, 'Канберра', 10),
(11, 4, 'Сидней', 0),
(12, 4, 'Мельбурн', 0),
-- Вопрос 5 (Столица Бразилии)
(13, 5, 'Бразилиа', 10),
(14, 5, 'Рио-де-Жанейро', 0),
(15, 5, 'Сан-Паулу', 0),
-- Вопрос 6 (Столица Египта)
(16, 6, 'Каир', 10),
(17, 6, 'Александрия', 0),
(18, 6, 'Луксор', 0),
-- Вопрос 7 (Столица Индии)
(19, 7, 'Нью-Дели', 10),
(20, 7, 'Мумбаи', 0),
(21, 7, 'Калькутта', 0),
-- Вопрос 8 (Столица ЮАР)
(22, 8, 'Претория', 10),
(23, 8, 'Кейптаун', 0),
(24, 8, 'Йоханнесбург', 0),
-- Вопрос 9 (Самая длинная река)
(25, 9, 'Амазонка', 10),
(26, 9, 'Нил', 0),
(27, 9, 'Янцзы', 0),
-- Вопрос 10 (Самое глубокое озеро)
(28, 10, 'Байкал', 10),
(29, 10, 'Танганьика', 0),
(30, 10, 'Верхнее', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `scenario_id` int NOT NULL,
  `question_text` text NOT NULL,
  `question_order` int NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `scenario_id`, `question_text`, `question_order`) VALUES
-- Сценарий 1: Столицы мира (8 вопросов)
(1, 1, 'Какая столица Франции?', 1),
(2, 1, 'Какая столица Японии?', 2),
(3, 1, 'Какая столица Канады?', 3),
(4, 1, 'Какая столица Австралии?', 4),
(5, 1, 'Какая столица Бразилии?', 5),
(6, 1, 'Какая столица Египта?', 6),
(7, 1, 'Какая столица Индии?', 7),
(8, 1, 'Какая столица ЮАР?', 8),
-- Сценарий 2: Реки и озера (минимум 8 вопросов, здесь показано 2 для примера, остальные аналогично)
(9, 2, 'Какая самая длинная река в мире?', 1),
(10, 2, 'Какое озеро самое глубокое в мире?', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `scenario_id` int NOT NULL,
  `total_score` int NOT NULL DEFAULT 0,
  `result_label` varchar(100) NOT NULL,
  `passed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `scenarios`
--

CREATE TABLE `scenarios` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `scenarios`
--

INSERT INTO `scenarios` (`id`, `title`, `description`, `category`, `created_at`) VALUES
(1, 'Столицы мира', 'Проверьте свои знания столиц государств', 'Политическая география', '2025-03-10 10:00:00'),
(2, 'Реки и озёра', 'Водные артерии планеты', 'Гидрография', '2025-03-10 10:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Администратор', 'admin@geo.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-03-10 10:00:00');
-- Пароль: password

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `scenario_id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer_id` int NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scenario_id` (`scenario_id`);

ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `scenario_id` (`scenario_id`);

ALTER TABLE `scenarios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `scenario_id` (`scenario_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `scenarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `user_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа
--

ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE CASCADE;

ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_4` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE;
COMMIT;
