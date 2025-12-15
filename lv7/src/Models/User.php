<?php

declare(strict_types=1);

namespace UserManagementSystem\Models;

use UserManagementSystem\Database\DatabaseConnection;
use InvalidArgumentException;

/**
 * Класс для работы с пользователями
 */
class User
{
    /**
     * Имя пользователя
     * @var string
     */
    private string $name;

    /**
     * Email пользователя
     * @var string
     */
    private string $email;

    /**
     * Конструктор
     * @param string $name Имя пользователя
     * @param string $email Email пользователя
     * @throws InvalidArgumentException Если данные невалидны
     */
    public function __construct(string $name, string $email)
    {
        $this->setName($name);
        $this->setEmail($email);
    }

    /**
     * Установить имя пользователя
     * @param string $name Имя пользователя
     * @return void
     * @throws InvalidArgumentException Если имя невалидно
     */
    public function setName(string $name): void
    {
        $name = trim($name);

        if (empty($name)) {
            throw new InvalidArgumentException('Имя не может быть пустым');
        }

        if (strlen($name) < 2) {
            throw new InvalidArgumentException('Имя должно содержать минимум 2 символа');
        }

        if (strlen($name) > 100) {
            throw new InvalidArgumentException('Имя не должно превышать 100 символов');
        }

        $this->name = $name;
    }

    /**
     * Установить email пользователя
     * @param string $email Email пользователя
     * @return void
     * @throws InvalidArgumentException Если email невалиден или уже существует
     */
    public function setEmail(string $email): void
    {
        $email = trim($email);

        if (empty($email)) {
            throw new InvalidArgumentException('Email не может быть пустым');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректный формат email');
        }

        if (strlen($email) > 100) {
            throw new InvalidArgumentException('Email не должен превышать 100 символов');
        }

        if (DatabaseConnection::emailExists($email)) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $this->email = $email;
    }

    /**
     * Получить имя пользователя
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить email пользователя
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Сохранить пользователя в базу данных
     * @return bool
     */
    public function save(): bool
    {
        return DatabaseConnection::addUser($this->name, $this->email);
    }

    /**
     * Создать пользователя из данных консоли
     * @return self
     * @throws InvalidArgumentException Если данные невалидны
     */
    public static function createFromConsole(): self
    {
        echo "\n=== ДОБАВЛЕНИЕ НОВОГО ПОЛЬЗОВАТЕЛЯ ===\n";

        $name = self::readConsoleInput('Введите имя пользователя: ');
        $email = self::readConsoleInput('Введите email пользователя: ');

        return new self($name, $email);
    }

    /**
     * Прочитать ввод из консоли
     * @param string $prompt Подсказка для ввода
     * @return string
     */
    private static function readConsoleInput(string $prompt): string
    {
        echo $prompt;
        return trim(fgets(STDIN));
    }

    /**
     * Добавить пользователя через консоль с валидацией
     * @return void
     */
    public static function addUserFromConsole(): void
    {
        while (true) {
            try {
                $user = self::createFromConsole();
                
                echo "\nПроверьте введенные данные:\n";
                echo "Имя: " . $user->getName() . "\n";
                echo "Email: " . $user->getEmail() . "\n";
                
                echo "\nДобавить пользователя? (y/n): ";
                $confirm = strtolower(trim(fgets(STDIN)));
                
                if (in_array($confirm, ['y', 'yes', 'д', 'да'])) {
                    if ($user->save()) {
                        echo "\n✓ Пользователь успешно добавлен!\n";
                    } else {
                        echo "\n✗ Ошибка при добавлении пользователя\n";
                    }
                    break;
                } else {
                    echo "\nДобавление отменено\n";
                    break;
                }
                
            } catch (InvalidArgumentException $e) {
                echo "\n✗ Ошибка валидации: " . $e->getMessage() . "\n";
                echo "Пожалуйста, попробуйте снова.\n\n";
            }
        }
    }

    /**
     * Получить массив всех пользователей
     * @return array<array<string, mixed>>
     */
    public static function getAll(): array
    {
        return DatabaseConnection::getAllUsers();
    }

    /**
     * Отобразить всех пользователей
     * @return void
     */
    public static function displayAll(): void
    {
        DatabaseConnection::displayAllUsers();
    }
}