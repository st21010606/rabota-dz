<?php
// Простой тест без базы данных

echo "Тест приложения\n";
echo "===============\n\n";

// Тест валидации email
$test_email = "test@example.com";
if (filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
    echo "✓ Email валидация работает\n";
} else {
    echo "✗ Ошибка валидации email\n";
}

// Тест ввода
echo "\nВведите ваше имя: ";
$name = trim(fgets(STDIN));
echo "Привет, $name!\n";

// Проверка доступности MySQL
echo "\nПроверка MySQL...\n";
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "✓ MySQL доступен\n";
} catch (Exception $e) {
    echo "✗ MySQL недоступен: " . $e->getMessage() . "\n";
    echo "Совет: Запустите XAMPP и запустите MySQL\n";
}
?>