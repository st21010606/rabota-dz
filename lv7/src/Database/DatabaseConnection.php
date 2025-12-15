<?php

declare(strict_types=1);

namespace UserManagementSystem\Database;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Класс для работы с базой данных через PDO
 */
class DatabaseConnection
{
    /**
     * Экземпляр PDO
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    /**
     * Конфигурация базы данных
     * @var array<string, mixed>
     */
    private static array $config = [];

    /**
     * Установить конфигурацию базы данных
     * @param array<string, mixed> $config
     * @return void
     */
    public static function setConfig(array $config): void
    {
        self::$config = $config;
    }

    /**
     * Получить соединение с базой данных
     * @return PDO
     * @throws RuntimeException Если не удалось подключиться к БД
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=%s',
                    self::$config['host'],
                    self::$config['dbname'],
                    self::$config['charset']
                );

                self::$pdo = new PDO(
                    $dsn,
                    self::$config['username'],
                    self::$config['password'],
                    self::$config['options']
                );
            } catch (PDOException $e) {
                throw new RuntimeException(
                    'Не удалось подключиться к базе данных: ' . $e->getMessage(),
                    0,
                    $e
                );
            }
        }

        return self::$pdo;
    }

    /**
     * Получить все записи из таблицы users
     * @return array<array<string, mixed>>
     */
    public static function getAllUsers(): array
    {
        $pdo = self::getConnection();
        $stmt = $pdo->query('SELECT id, name, email FROM users ORDER BY id');
        
        $result = $stmt->fetchAll();
        
        return $result !== false ? $result : [];
    }

    /**
     * Вывести все записи из таблицы users в форматированном виде
     * @return void
     */
    public static function displayAllUsers(): void
    {
        $users = self::getAllUsers();

        if (empty($users)) {
            echo "Таблица users пуста.\n";
            return;
        }

        echo "\n=== СПИСОК ПОЛЬЗОВАТЕЛЕЙ ===\n";
        echo str_repeat("-", 70) . "\n";
        printf("%-5s | %-30s | %-30s\n", "ID", "Имя", "Email");
        echo str_repeat("-", 70) . "\n";

        foreach ($users as $user) {
            printf(
                "%-5s | %-30s | %-30s\n",
                $user['id'],
                $user['name'],
                $user['email']
            );
        }

        echo str_repeat("-", 70) . "\n";
        echo "Всего пользователей: " . count($users) . "\n";
    }

    /**
     * Проверить существует ли email в базе данных
     * @param string $email Email для проверки
     * @return bool
     */
    public static function emailExists(string $email): bool
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Добавить нового пользователя
     * @param string $name Имя пользователя
     * @param string $email Email пользователя
     * @return bool
     */
    public static function addUser(string $name, string $email): bool
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
        
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);
    }

    /**
     * Выполнить произвольный SQL запрос
     * @param string $sql SQL запрос
     * @param array<string, mixed> $params Параметры запроса
     * @return array<array<string, mixed>>
     */
    public static function query(string $sql, array $params = []): array
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        $result = $stmt->fetchAll();
        
        return $result !== false ? $result : [];
    }

    /**
     * Закрыть соединение с базой данных
     * @return void
     */
    public static function close(): void
    {
        self::$pdo = null;
    }
}