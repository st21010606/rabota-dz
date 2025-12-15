<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use BankAccountSystem\BankAccount;
use BankAccountSystem\Exceptions\InvalidAmountException;
use BankAccountSystem\Exceptions\InsufficientFundsException;

echo "=== БАНКОВСКАЯ СИСТЕМА - ДЕМОНСТРАЦИЯ РАБОТЫ ===\n\n";

try {
    // Тест 1: Создание счета с положительным начальным балансом
    echo "1. Создание банковского счета:\n";
    echo str_repeat("-", 50) . "\n";
    
    $account = new BankAccount(1000.00);
    echo "✓ Счет успешно создан\n";
    echo "Начальный баланс: " . $account->getBalance() . " руб.\n\n";
    
} catch (InvalidAmountException $e) {
    echo "✗ Ошибка при создании счета: " . $e->getMessage() . "\n";
    exit(1);
}

// Тест 2: Пополнение счета
echo "2. Пополнение счета:\n";
echo str_repeat("-", 50) . "\n";

try {
    $account->deposit(500.00);
    echo "✓ Успешное пополнение на 500.00 руб.\n";
    echo "Баланс после пополнения: " . $account->getBalance() . " руб.\n\n";
} catch (InvalidAmountException $e) {
    echo "✗ Ошибка при пополнении: " . $e->getMessage() . "\n";
}

// Тест 3: Попытка пополнения отрицательной суммой
echo "3. Попытка пополнения отрицательной суммой:\n";
echo str_repeat("-", 50) . "\n";

try {
    $account->deposit(-100.00);
    echo "✓ Успешное пополнение (не должно выводиться)\n";
} catch (InvalidAmountException $e) {
    echo "✗ Ожидаемая ошибка: " . $e->getMessage() . "\n";
    echo "Баланс остался без изменений: " . $account->getBalance() . " руб.\n\n";
}

// Тест 4: Успешное снятие средств
echo "4. Успешное снятие средств:\n";
echo str_repeat("-", 50) . "\n";

try {
    $account->withdraw(300.00);
    echo "✓ Успешное снятие 300.00 руб.\n";
    echo "Баланс после снятия: " . $account->getBalance() . " руб.\n\n";
} catch (InvalidAmountException | InsufficientFundsException $e) {
    echo "✗ Ошибка при снятии: " . $e->getMessage() . "\n";
}

// Тест 5: Попытка снятия суммы больше баланса
echo "5. Попытка снятия суммы больше баланса:\n";
echo str_repeat("-", 50) . "\n";

try {
    $account->withdraw(2000.00);
    echo "✓ Успешное снятие (не должно выводиться)\n";
} catch (InsufficientFundsException $e) {
    echo "✗ Ожидаемая ошибка: " . $e->getMessage() . "\n";
    echo "Баланс остался без изменений: " . $account->getBalance() . " руб.\n\n";
}

// Тест 6: Попытка снятия нулевой суммы
echo "6. Попытка снятия нулевой суммы:\n";
echo str_repeat("-", 50) . "\n";

try {
    $account->withdraw(0.00);
    echo "✓ Успешное снятие (не должно выводиться)\n";
} catch (InvalidAmountException $e) {
    echo "✗ Ожидаемая ошибка: " . $e->getMessage() . "\n";
    echo "Баланс остался без изменений: " . $account->getBalance() . " руб.\n\n";
}

// Тест 7: Массовые операции
echo "7. Выполнение нескольких операций:\n";
echo str_repeat("-", 50) . "\n";

$operations = [
    ['type' => 'deposit', 'amount' => 200.00],
    ['type' => 'withdraw', 'amount' => 100.00],
    ['type' => 'deposit', 'amount' => -50.00],  // Ошибочная операция
    ['type' => 'withdraw', 'amount' => 1000.00], // Ошибочная операция
    ['type' => 'withdraw', 'amount' => 50.00],
    ['type' => 'deposit', 'amount' => 0.00],     // Ошибочная операция
];

$account->executeOperations($operations);

// Тест 8: Финальная проверка баланса
echo "8. Финальная проверка:\n";
echo str_repeat("-", 50) . "\n";
echo $account->getAccountInfo() . "\n\n";

// Тест 9: Создание счета с отрицательным балансом
echo "9. Попытка создания счета с отрицательным балансом:\n";
echo str_repeat("-", 50) . "\n";

try {
    $badAccount = new BankAccount(-500.00);
    echo "✓ Счет создан (не должно выводиться)\n";
} catch (InvalidAmountException $e) {
    echo "✗ Ожидаемая ошибка: " . $e->getMessage() . "\n";
}

// Тест 10: Интерактивный режим (если запущено в CLI)
if (php_sapi_name() === 'cli') {
    echo "\n10. Интерактивный режим:\n";
    echo str_repeat("-", 50) . "\n";
    
    $interactiveAccount = new BankAccount(1000.00);
    echo "Создан новый счет с балансом 1000.00 руб.\n";
    
    while (true) {
        echo "\nВыберите действие:\n";
        echo "1. Показать баланс\n";
        echo "2. Пополнить счет\n";
        echo "3. Снять деньги\n";
        echo "4. Выйти\n";
        echo "Ваш выбор: ";
        
        $choice = trim(fgets(STDIN));
        
        switch ($choice) {
            case '1':
                echo "Текущий баланс: " . $interactiveAccount->getBalance() . " руб.\n";
                break;
                
            case '2':
                echo "Введите сумму для пополнения: ";
                $amount = (float) trim(fgets(STDIN));
                
                try {
                    $interactiveAccount->deposit($amount);
                    echo "✓ Успешное пополнение на {$amount} руб.\n";
                } catch (InvalidAmountException $e) {
                    echo "✗ Ошибка: " . $e->getMessage() . "\n";
                }
                break;
                
            case '3':
                echo "Введите сумму для снятия: ";
                $amount = (float) trim(fgets(STDIN));
                
                try {
                    $interactiveAccount->withdraw($amount);
                    echo "✓ Успешное снятие {$amount} руб.\n";
                } catch (InvalidAmountException | InsufficientFundsException $e) {
                    echo "✗ Ошибка: " . $e->getMessage() . "\n";
                }
                break;
                
            case '4':
                echo "До свидания!\n";
                break 2;
                
            default:
                echo "Неверный выбор. Попробуйте снова.\n";
                break;
        }
    }
}

echo "\n=== ДЕМОНСТРАЦИЯ ЗАВЕРШЕНА ===\n";