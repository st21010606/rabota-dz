<?php

declare(strict_types=1);

namespace BankAccount\Exceptions;

use Exception;

class InvalidAmountException extends Exception
{
    public function __construct(string $message = "Cумма должна быть положительной")
    {
        parent::__construct($message);
    }
}