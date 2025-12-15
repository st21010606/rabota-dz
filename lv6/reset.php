<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

if (isset($_SESSION['bank_account'])) {
    unset($_SESSION['bank_account']);
}

header('Location: public/index.php');
exit();
?>