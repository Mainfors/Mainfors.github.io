CREATE DATABASE artspace;

USE artspace;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role enum('user','admin') NOT NULL DEFAULT 'user'
);

INSERT INTO users (id, login, password, name,phone, email, role) VALUES (1, 'ArtAdmin','Creative', 'Админ','123','adm@u.ru', 'admin');

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    requests VARCHAR(100) NOT NULL,
    visit_date DATE NOT NULL,
    payment VARCHAR(100) NOT NULL,
    status VARCHAR(100) DEFAULT 'Заявка подана',
    review TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

