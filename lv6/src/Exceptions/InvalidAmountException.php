<?php

declare(strict_types=1);

namespace BankAccountSystem\Exceptions;

use Exception;

/**
 * Исключение для недопустимых сумм
 */
class InvalidAmountException extends Exception
{
    /**
     * Конструктор
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки
     * @param Exception|null $previous Предыдущее исключение
     */
    public function __construct(
        string $message = "Недопустимая сумма операции",
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}