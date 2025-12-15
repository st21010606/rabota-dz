<?php
class User {
    private $database;
    
    public function __construct($database) {
        $this->database = $database;
    }
    
    private function validateName($name) {
        if (empty(trim($name))) {
            echo "✗ Имя не может быть пустым\n";
            return false;
        }
        
        if (strlen($name) < 2) {
            echo "✗ Имя должно быть не менее 2 символов\n";
            return false;
        }
        
        return true;
    }
    
    private function validateEmail($email) {
        $email = trim($email);
        
        if (empty($email)) {
            echo "✗ Email не может быть пустым\n";
            return false;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "✗ Неверный формат email\n";
            return false;
        }
        
        if ($this->database->emailExists($email)) {
            echo "✗ Такой email уже существует\n";
            return false;
        }
        
        return true;
    }
    
    public function addUserFromConsole() {
        echo "\n--- Добавление нового пользователя ---\n";
        
        // Ввод имени
        do {
            echo "Введите имя: ";
            $name = trim(fgets(STDIN));
        } while (!$this->validateName($name));
        
        // Ввод email
        do {
            echo "Введите email: ";
            $email = trim(fgets(STDIN));
        } while (!$this->validateEmail($email));
        
        // Подтверждение
        echo "\nПодтвердите данные:\n";
        echo "Имя: $name\n";
        echo "Email: $email\n";
        echo "\nДобавить пользователя? (y/n): ";
        
        $confirm = strtolower(trim(fgets(STDIN)));
        
        if ($confirm === 'y' || $confirm === 'yes' || $confirm === 'д' || $confirm === 'да') {
            if ($this->database->addUser($name, $email)) {
                echo "✓ Пользователь успешно добавлен!\n";
            } else {
                echo "✗ Ошибка при добавлении\n";
            }
        } else {
            echo "Добавление отменено\n";
        }
    }
    
    public function displayAllUsers() {
        $this->database->displayAllUsers();
    }
    
    // Метод для теста
    public function addTestUser() {
        $this->database->addTestUser();
    }
}
?>