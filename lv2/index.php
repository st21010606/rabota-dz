<?php
// Автозагрузка через Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Utils\StringUtils;
use App\Utils\NumberUtils;
use App\Utils\TextAnalyzer;

echo "=== РЕШЕНИЕ ЗАДАЧ НА PHP ===\n\n";

// Задача 1: alphabeticalOrder
echo "1. Функция alphabeticalOrder:\n";
$str = 'alphabetical';
$result = StringUtils::alphabeticalOrder($str);
echo "   Вход: '$str'\n";
echo "   Результат: '$result'\n";
echo "   Ожидалось: 'aaabcehillpt'\n";
echo "   Тест: " . ($result === 'aaabcehillpt' ? '✓ ПРОЙДЕН' : '✗ НЕ ПРОЙДЕН') . "\n\n";

// Задача 2: Поиск совершенных чисел
echo "2. Поиск совершенных чисел:\n";
$numbers = [6, 12, 28, 496, 8128, 10, 15];
$perfect = NumberUtils::findFirstPerfectNumber($numbers);
echo "   Массив: [" . implode(', ', $numbers) . "]\n";
echo "   Первое совершенное число: " . ($perfect ?? 'не найдено') . "\n";
echo "   Проверка чисел:\n";
echo "     6: " . (NumberUtils::isPerfectNumber(6) ? 'совершенное' : 'не совершенное') . "\n";
echo "     28: " . (NumberUtils::isPerfectNumber(28) ? 'совершенное' : 'не совершенное') . "\n";
echo "     12: " . (NumberUtils::isPerfectNumber(12) ? 'совершенное' : 'не совершенное') . "\n\n";

// Задача 3: mostRecent
echo "3. Функция mostRecent:\n";
$text = "hello world hello everyone world hello";
$word = TextAnalyzer::mostRecent($text);
echo "   Текст: '$text'\n";
echo "   Самое частое слово: '" . ($word ?? 'не найдено') . "'\n";
echo "   Тест: " . ($word === 'hello' ? '✓ ПРОЙДЕН' : '✗ НЕ ПРОЙДЕН') . "\n\n";

echo "=== ВСЕ ТЕСТЫ ЗАВЕРШЕНЫ ===\n";

// Дополнительные примеры
if (php_sapi_name() === 'cli') {
    echo "\n--- Дополнительные примеры ---\n";
    
    // Русский текст
    $russianText = "раз два три два три два";
    echo "Текст: '$russianText'\n";
    echo "Самое частое слово: " . TextAnalyzer::mostRecent($russianText) . "\n";
    
    // Сортировка других строк
    echo "\nДругие примеры alphabeticalOrder:\n";
    echo "'php' → '" . StringUtils::alphabeticalOrder('php') . "'\n";
    echo "'programming' → '" . StringUtils::alphabeticalOrder('programming') . "'\n";
}
?>