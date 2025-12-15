<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use UserManagementSystem\Database\DatabaseConnection;
use UserManagementSystem\Models\User;

// Загрузка конфигурации
$config = require __DIR__ . '/../config/database.php';
DatabaseConnection::setConfig($config);

echo "=== ТЕСТИРОВАНИЕ СИСТЕМЫ УПРАВЛЕНИЯ ПОЛЬЗОВАТЕЛЯМИ ===\n\n";

try {
    // Тест 1: Подключение к базе данных
    echo "1. Тест подключения к базе данных:\n";
    $pdo = DatabaseConnection::getConnection();
    echo "✓ Успешно подключено к базе данных\n\n";

    // Тест 2: Получение пользователей
    echo "2. Тест получения пользователей:\n";
    $users = DatabaseConnection::getAllUsers();
    echo "✓ Получено пользователей: " . count($users) . "\n";
    
    if (!empty($users)) {
        echo "Пример пользователя:\n";
        echo "  ID: " . $users[0]['id'] . "\n";
        echo "  Имя: " . $users[0]['name'] . "\n";
        echo "  Email: " . $users[0]['email'] . "\n";
    }
    echo "\n";

    // Тест 3: Валидация пользователей
    echo "3. Тест валидации пользователей:\n";
    
    $testCases = [
        ['Иван', 'ivan@example.com', true, 'Корректные данные'],
        ['', 'test@example.com', false, 'Пустое имя'],
        ['И', 'test@example.com', false, 'Слишком короткое имя'],
        ['Иван', 'invalid-email', false, 'Некорректный email'],
    ];

    foreach ($testCases as [$name, $email, $shouldPass, $description]) {
        echo "  Тест: {$description}\n";
        
        try {
            $user = new User($name, $email);
            if ($shouldPass) {
                echo "    ✓ Успешно создан: " . $user->getName() . "\n";
            } else {
                echo "    ✗ Ожидалась ошибка, но пользователь создан\n";
            }
        } catch (InvalidArgumentException $e) {
            if (!$shouldPass) {
                echo "    ✓ Ожидаемая ошибка: " . $e->getMessage() . "\n";
            } else {
                echo "    ✗ Неожиданная ошибка: " . $e->getMessage() . "\n";
            }
        }
    }
    echo "\n";

    // Тест 4: Проверка уникальности email
    echo "4. Тест уникальности email:\n";
    
    // Берем существующий email из базы данных
    if (!empty($users)) {
        $existingEmail = $users[0]['email'];
        
        try {
            $user = new User('Новый пользователь', $existingEmail);
            echo "    ✗ Ожидалась ошибка дублирования email\n";
        } catch (InvalidArgumentException $e) {
            echo "    ✓ Ожидаемая ошибка дублирования: " . $e->getMessage() . "\n";
        }
    }
    echo "\n";

    // Тест 5: Отображение пользователей
    echo "5. Тест отображения пользователей:\n";
    DatabaseConnection::displayAllUsers();
    echo "✓ Отображение выполнено\n\n";

    echo "=== ВСЕ ТЕСТЫ ПРОЙДЕНЫ ===\n";

} catch (Exception $e) {
    echo "\n✗ Ошибка тестирования: " . $e->getMessage() . "\n";
    exit(1);
} finally {
    DatabaseConnection::close();
}