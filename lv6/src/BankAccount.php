<?php

declare(strict_types=1);

namespace BankAccountSystem;

use BankAccountSystem\Exceptions\InvalidAmountException;
use BankAccountSystem\Exceptions\InsufficientFundsException;

/**
 * Класс банковского счета
 */
class BankAccount
{
    /**
     * Текущий баланс счета
     * @var float
     */
    private float $balance;

    /**
     * Конструктор банковского счета
     * @param float $initialBalance Начальный баланс
     * @throws InvalidAmountException Если начальный баланс отрицательный
     */
    public function __construct(float $initialBalance = 0.0)
    {
        if ($initialBalance < 0) {
            throw new InvalidAmountException(
                "Начальный баланс не может быть отрицательным. Передано: {$initialBalance}"
            );
        }
        
        $this->balance = $initialBalance;
    }

    /**
     * Получить текущий баланс
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Пополнить счет
     * @param float $amount Сумма для пополнения
     * @return void
     * @throws InvalidAmountException Если сумма отрицательная или равна нулю
     */
    public function deposit(float $amount): void
    {
        $this->validateAmount($amount, 'пополнения');
        $this->balance += $amount;
    }

    /**
     * Снять деньги со счета
     * @param float $amount Сумма для снятия
     * @return void
     * @throws InvalidAmountException Если сумма отрицательная или равна нулю
     * @throws InsufficientFundsException Если сумма превышает баланс
     */
    public function withdraw(float $amount): void
    {
        $this->validateAmount($amount, 'снятия');
        
        if ($amount > $this->balance) {
            throw new InsufficientFundsException(
                sprintf(
                    "Попытка снятия %.2f при балансе %.2f",
                    $amount,
                    $this->balance
                )
            );
        }
        
        $this->balance -= $amount;
    }

    /**
     * Проверить корректность суммы
     * @param float $amount Сумма для проверки
     * @param string $operationType Тип операции (для сообщения об ошибке)
     * @return void
     * @throws InvalidAmountException Если сумма некорректна
     */
    private function validateAmount(float $amount, string $operationType): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException(
                sprintf(
                    "Сумма %s должна быть положительной. Передано: %.2f",
                    $operationType,
                    $amount
                )
            );
        }
    }

    /**
     * Получить информацию о счете
     * @return string
     */
    public function getAccountInfo(): string
    {
        return sprintf("Баланс счета: %.2f руб.", $this->balance);
    }

    /**
     * Выполнить несколько операций
     * @param array $operations Массив операций [['type' => 'deposit', 'amount' => 100], ...]
     * @return void
     */
    public function executeOperations(array $operations): void
    {
        foreach ($operations as $index => $operation) {
            $operationNumber = $index + 1;
            
            try {
                if ($operation['type'] === 'deposit') {
                    $this->deposit($operation['amount']);
                    echo "[Операция {$operationNumber}] Успешное пополнение на {$operation['amount']} руб." . PHP_EOL;
                } elseif ($operation['type'] === 'withdraw') {
                    $this->withdraw($operation['amount']);
                    echo "[Операция {$operationNumber}] Успешное снятие {$operation['amount']} руб." . PHP_EOL;
                }
            } catch (\Exception $e) {
                echo "[Операция {$operationNumber}] Ошибка: " . $e->getMessage() . PHP_EOL;
            }
            
            echo "Текущий баланс: {$this->getBalance()} руб." . PHP_EOL . PHP_EOL;
        }
    }
}