<?php

declare(strict_types=1);

namespace BankAccountSystem\Exceptions;

use Exception;

/**
 * Исключение для недостаточных средств
 */
class InsufficientFundsException extends Exception
{
    /**
     * Конструктор
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки
     * @param Exception|null $previous Предыдущее исключение
     */
    public function __construct(
        string $message = "Недостаточно средств на счете",
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}