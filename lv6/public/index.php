<?php

declare(strict_types=1);

// Включить отображение ошибок
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use BankAccount\BankAccount;
use BankAccount\Exceptions\InvalidAmountException;
use BankAccount\Exceptions\InsufficientFundsException;

// Инициализация сессии
session_start();

// Создаем или восстанавливаем банковский счет
if (!isset($_SESSION['bank_account'])) {
    try {
        $_SESSION['bank_account'] = new BankAccount(1000.0);
    } catch (InvalidAmountException $e) {
        die("Ошибка создания счета: " . $e->getMessage());
    }
}

/** @var BankAccount $account */
$account = $_SESSION['bank_account'];
$message = '';
$message_type = '';

// Обработка форм
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim($_POST['action'] ?? '');
    $amountInput = trim($_POST['amount'] ?? '0');
    
    // Валидация ввода
    if (!is_numeric($amountInput)) {
        $message = "Ошибка: Сумма должна быть числом";
        $message_type = 'error';
    } else {
        $amount = (float)$amountInput;
        
        try {
            switch ($action) {
                case 'deposit':
                    $newBalance = $account->deposit($amount);
                    $message = sprintf(
                        "Успешно пополнено: %.2f единиц. Новый баланс: %.2f",
                        $amount,
                        $newBalance
                    );
                    $message_type = 'success';
                    break;
                    
                case 'withdraw':
                    $newBalance = $account->withdraw($amount);
                    $message = sprintf(
                        "Успешно снято: %.2f единиц. Новый баланс: %.2f",
                        $amount,
                        $newBalance
                    );
                    $message_type = 'success';
                    break;
                    
                default:
                    $message = "Неизвестное действие";
                    $message_type = 'error';
            }
        } catch (InvalidAmountException $e) {
            $message = "Ошибка: Неверная сумма - " . $e->getMessage();
            $message_type = 'error';
        } catch (InsufficientFundsException $e) {
            $message = "Ошибка: Недостаточно средств - " . $e->getMessage();
            $message_type = 'error';
        } catch (Throwable $e) {
            $message = "Неизвестная ошибка: " . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .message { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .balance { background-color: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .form-container { display: flex; gap: 20px; margin: 20px 0; }
        .form-box { border: 1px solid #dee2e6; padding: 20px; border-radius: 5px; flex: 1; }
        input[type="number"] { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .deposit-btn { background-color: #28a745; color: white; }
        .withdraw-btn { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <?php if ($message !== ''): ?>
        <div class="message <?php echo htmlspecialchars($message_type); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    
    <div class="balance">
        <h2>Текущий баланс: <strong><?php echo number_format($account->getBalance(), 2); ?></strong></h2>
    </div>
    
    <div class="form-container">
        <div class="form-box">
            <h3>📥 Пополнить счет</h3>
            <form method="POST">
                <input type="hidden" name="action" value="deposit">
                <label for="deposit-amount">Сумма пополнения:</label>
                <input type="number" id="deposit-amount" name="amount" required>
                <button type="submit" class="deposit-btn">Пополнить</button>
            </form>
        </div>
        
        <div class="form-box">
            <h3>📤 Снять средства</h3>
            <form method="POST">
                <input type="hidden" name="action" value="withdraw">
                <label for="withdraw-amount">Сумма снятия:</label>
                <input type="number" id="withdraw-amount" name="amount" required>
                <button type="submit" class="withdraw-btn">Снять</button>
            </form>
        </div>
    </div>
</body>
</html>