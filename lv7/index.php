<?php
/**
 * Основной файл приложения
 */

// Автозагрузка классов
spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Конфигурация базы данных
$config = [
    'host' => 'localhost',
    'dbname' => 'your_database_name',
    'username' => 'your_username',
    'password' => 'your_password'
];

// Создание необходимых таблиц (раскомментировать при первом запуске)
function createTables($pdo) {
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    try {
        $pdo->exec($query);
        echo "Таблица users создана или уже существует.\n";
    } catch (PDOException $e) {
        die("Ошибка при создании таблицы: " . $e->getMessage() . "\n");
    }
}

// Главное меню
function showMenu() {
    echo "\nМеню:\n";
    echo str_repeat("-", 30) . "\n";
    echo "1. Показать всех пользователей\n";
    echo "2. Добавить нового пользователя\n";
    echo "3. Выход\n";
    echo str_repeat("-", 30) . "\n";
    echo "Выберите действие (1-3): ";
}

// Основной скрипт
try {
    // Инициализация базы данных
    $database = new Database(
        $config['host'],
        $config['dbname'],
        $config['username'],
        $config['password']
    );
    
    // Создание таблицы (раскомментировать при первом запуске)
    // createTables($database->getPDO()); // Нужно добавить метод getPDO() в класс Database
    
    // Инициализация пользователя
    $user = new User($database);
    
    // Основной цикл программы
    while (true) {
        showMenu();
        $choice = trim(fgets(STDIN));
        
        switch ($choice) {
            case '1':
                $user->displayAllUsers();
                break;
                
            case '2':
                $user->addUserFromConsole();
                break;
                
            case '3':
                echo "Выход из программы.\n";
                exit(0);
                
            default:
                echo "Неверный выбор. Попробуйте снова.\n";
                break;
        }
    }
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
    exit(1);
}
?>