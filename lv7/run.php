<?php
// Упрощенная версия для быстрого запуска

// Автозагрузка классов
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

// Конфигурация для XAMPP
$config = [
    'host' => 'localhost',
    'dbname' => 'test',
    'username' => 'root',
    'password' => ''
];

try {
    echo "=== Тестовое приложение ===\n";
    
    // Подключаемся к базе данных
    $db = new Database($config['host'], $config['dbname'], 
                      $config['username'], $config['password']);
    
    // Создаем таблицу если нужно
    $db->createTable();
    
    // Создаем объект пользователя
    $user = new User($db);
    
    // Простой тест
    echo "\n1. Добавляем тестового пользователя...\n";
    $user->addTestUser();
    
    echo "\n2. Показываем всех пользователей...\n";
    $user->displayAllUsers();
    
    echo "\nГотово! Проверьте базу данных.\n";
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
?>