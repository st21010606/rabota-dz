<?php

declare(strict_types=1);

namespace BankAccount;

use BankAccount\Exceptions\InvalidAmountException;
use BankAccount\Exceptions\InsufficientFundsException;

class BankAccount
{
    private float $balance;

    /**
     * @throws InvalidAmountException
     */
    public function __construct(float $initialBalance = 0.0)
    {
        if ($initialBalance < 0) {
            throw new InvalidAmountException("Initial balance cannot be negative");
        }
        $this->balance = $initialBalance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @throws InvalidAmountException
     */
    public function deposit(float $amount): float
    {
        if ($amount <= 0) {
            throw new InvalidAmountException(
                sprintf("Сумма депозита должна быть положительной, полученно: %.2f", $amount)
            );
        }
        
        $this->balance += $amount;
        return $this->balance;
    }

    /**
     * @throws InvalidAmountException|InsufficientFundsException
     */
    public function withdraw(float $amount): float
    {
        if ($amount <= 0) {
            throw new InvalidAmountException(
                sprintf("Сумма вывода должна быть положительной: %.2f", $amount)
            );
        }
        
        if ($amount > $this->balance) {
            throw new InsufficientFundsException(
                sprintf("Не удается вывести %.2f. Текущий баланс: %.2f", $amount, $this->balance)
            );
        }
        
        $this->balance -= $amount;
        return $this->balance;
    }
}