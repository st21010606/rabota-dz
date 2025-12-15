-- Создание базы данных
CREATE DATABASE IF NOT EXISTS user_management 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE user_management;

-- Создание таблицы users
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Вставка тестовых данных
INSERT INTO users (name, email) VALUES
('Иван Иванов', 'ivan@example.com'),
('Петр Петров', 'petr@example.com'),
('Мария Сидорова', 'maria@example.com');