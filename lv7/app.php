<?php
// Подключаем классы
require_once 'Database.php';
require_once 'User.php';

// Конфигурация БД
$config = [
    'host' => 'localhost',
    'dbname' => 'user_db',
    'username' => 'root',
    'password' => '' // для XAMPP пароль пустой
];

// Функция отображения меню
function showMenu() {
    echo "\n=== Управление пользователями ===\n";
    echo "1. Показать всех пользователей\n";
    echo "2. Добавить нового пользователя\n";
    echo "3. Выход\n";
    echo "Выберите действие (1-3): ";
}

try {
    // Создаем объект базы данных
    $db = new Database(
        $config['host'],
        $config['dbname'],
        $config['username'],
        $config['password']
    );
    
    // Создаем таблицу если её нет
    $db->createTable();
    
    // Создаем объект пользователя
    $user = new User($db);
    
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
                echo "\nДо свидания!\n";
                exit(0);
                
            default:
                echo "\n✗ Неверный выбор. Попробуйте снова.\n";
                break;
        }
    }
    
} catch (Exception $e) {
    echo "\n✗ Ошибка: " . $e->getMessage() . "\n";
}
?>