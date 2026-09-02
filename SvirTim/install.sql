-- Создание базы данных
CREATE DATABASE IF NOT EXISTS dagestanovo;
USE dagestanovo;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица кабинетов
CREATE TABLE IF NOT EXISTS cabinets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    description TEXT
);

-- Таблица заявок
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cabinet_id INT NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cabinet_id) REFERENCES cabinets(id) ON DELETE CASCADE
);

-- Добавление тестовых данных
INSERT INTO cabinets (name, location, capacity, description) VALUES
('Переговорная А', 'Махачкала, ул. Ленина 10', 10, 'Большая переговорная с проектором'),
('Кабинет 101', 'Махачкала, пр. Петра 15', 4, 'Маленький кабинет для встреч'),
('Конференц-зал', 'Каспийск, ул. Гагарина 5', 30, 'Большой зал для конференций');

-- Добавление администратора (пароль: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Администратор', 'admin@dagestanovo.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Добавление тестового пользователя (пароль: user123)
INSERT INTO users (name, email, password, role) VALUES
('Тестовый пользователь', 'user@dagestanovo.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');