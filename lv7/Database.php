<?php
class Database {
    private $pdo;
    
    public function __construct($host, $dbname, $username, $password) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✓ Подключение к базе данных успешно!\n";
        } catch (PDOException $e) {
            die("✗ Ошибка подключения: " . $e->getMessage() . "\n");
        }
    }
    
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, name, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function displayAllUsers() {
        $users = $this->getAllUsers();
        
        if (empty($users)) {
            echo "Таблица users пуста.\n";
            return;
        }
        
        echo "\nСписок пользователей:\n";
        echo str_repeat("-", 60) . "\n";
        printf("%-5s | %-20s | %-30s\n", "ID", "Имя", "Email");
        echo str_repeat("-", 60) . "\n";
        
        foreach ($users as $user) {
            printf("%-5s | %-20s | %-30s\n", 
                $user['id'], 
                $user['name'], 
                $user['email']
            );
        }
        echo str_repeat("-", 60) . "\n";
    }
    
    public function addUser($name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $stmt->execute([$name, $email]);
    }
    
    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
        echo "✓ Таблица users готова к работе\n";
    }
    
    // Метод для тестового пользователя
    public function addTestUser() {
        $testName = "Тестовый пользователь";
        $testEmail = "test" . time() . "@example.com";
        
        if (!$this->emailExists($testEmail)) {
            $this->addUser($testName, $testEmail);
            echo "✓ Добавлен тестовый пользователь: $testEmail\n";
        }
    }
}
?>