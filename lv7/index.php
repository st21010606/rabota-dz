<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use UserManagementSystem\Database\DatabaseConnection;
use UserManagementSystem\Models\User;

// Загрузка конфигурации
$config = require __DIR__ . '/config/database.php';
DatabaseConnection::setConfig($config);

// Основное меню
function showMenu(): void
{
    echo "\n=== СИСТЕМА УПРАВЛЕНИЯ ПОЛЬЗОВАТЕЛЯМИ ===\n";
    echo "1. Показать всех пользователей\n";
    echo "2. Добавить нового пользователя\n";
    echo "3. Тестирование валидации\n";
    echo "4. Тестирование PDO\n";
    echo "5. Выход\n";
    echo str_repeat("-", 50) . "\n";
    echo "Выберите действие (1-5): ";
}

function testValidation(): void
{
    echo "\n=== ТЕСТИРОВАНИЕ ВАЛИДАЦИИ ===\n\n";

    $testCases = [
        ['', 'test@example.com', 'Пустое имя'],
        ['И', 'test@example.com', 'Имя слишком короткое'],
        ['Иван', 'invalid-email', 'Некорректный email'],
        ['Иван', 'ivan@example.com', 'Корректные данные'],
    ];

    foreach ($testCases as [$name, $email, $description]) {
        echo "Тест: {$description}\n";
        echo "Имя: '{$name}', Email: '{$email}'\n";

        try {
            $user = new User($name, $email);
            echo "✓ Успешно создан пользователь: " . $user->getName() . "\n";
        } catch (InvalidArgumentException $e) {
            echo "✗ Ошибка: " . $e->getMessage() . "\n";
        }

        echo "\n";
    }
}

function testPDO(): void
{
    echo "\n=== ТЕСТИРОВАНИЕ PDO ===\n\n";

    try {
        // Тест подключения
        $pdo = DatabaseConnection::getConnection();
        echo "✓ Подключение к базе данных успешно\n";

        // Тест запроса
        $users = DatabaseConnection::getAllUsers();
        echo "✓ Запрос к базе данных выполнен\n";
        echo "Найдено пользователей: " . count($users) . "\n";

        // Тест prepared statements
        $testEmail = 'test' . time() . '@example.com';
        $exists = DatabaseConnection::emailExists($testEmail);
        echo "✓ Проверка email выполнена (существует: " . ($exists ? 'да' : 'нет') . ")\n";

    } catch (Exception $e) {
        echo "✗ Ошибка PDO: " . $e->getMessage() . "\n";
    }
}

// Основной цикл программы
function main(): void
{
    echo "Добро пожаловать в систему управления пользователями!\n";

    while (true) {
        showMenu();
        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case '1':
                User::displayAll();
                break;

            case '2':
                User::addUserFromConsole();
                break;

            case '3':
                testValidation();
                break;

            case '4':
                testPDO();
                break;

            case '5':
                echo "\nДо свидания!\n";
                DatabaseConnection::close();
                exit(0);

            default:
                echo "\nНеверный выбор. Попробуйте снова.\n";
                break;
        }

        echo "\nНажмите Enter для продолжения...";
        fgets(STDIN);
    }
}

// Запуск программы
try {
    main();
} catch (Exception $e) {
    echo "\nКритическая ошибка: " . $e->getMessage() . "\n";
    DatabaseConnection::close();
    exit(1);
}