<?php

declare(strict_types=1);

namespace BankAccount\Exceptions;

use Exception;

class InsufficientFundsException extends Exception
{
    public function __construct(string $message = "Cумма вывода превышает баланс")
    {
        parent::__construct($message);
    }
}