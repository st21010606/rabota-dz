<?php
// Автозагрузка через Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\Utils\StringUtils;
use App\Utils\NumberUtils;
use App\Utils\TextAnalyzer;

class SimpleTest
{
    public static function run(): void
    {
        echo "=== ПРОСТОЕ ТЕСТИРОВАНИЕ ===\n\n";
        
        self::testAlphabeticalOrder();
        self::testPerfectNumbers();
        self::testMostRecent();
    }
    
    private static function testAlphabeticalOrder(): void
    {
        echo "Тест alphabeticalOrder():\n";
        $tests = [
            ['alphabetical', 'aaabcehillpt'],
            ['hello', 'ehllo'],
            ['world', 'dlorw'],
            ['test', 'estt'],
        ];
        
        $passed = 0;
        foreach ($tests as [$input, $expected]) {
            $result = StringUtils::alphabeticalOrder($input);
            if ($result === $expected) {
                echo "  ✓ '$input' → '$result'\n";
                $passed++;
            } else {
                echo "  ✗ '$input' → '$result' (ожидалось: '$expected')\n";
            }
        }
        echo "  Результат: $passed/" . count($tests) . " тестов пройдено\n\n";
    }
    
    private static function testPerfectNumbers(): void
    {
        echo "Тест perfect numbers():\n";
        $tests = [
            [6, true],
            [28, true],
            [496, true],
            [12, false],
            [15, false],
        ];
        
        $passed = 0;
        foreach ($tests as [$num, $expected]) {
            $result = NumberUtils::isPerfectNumber($num);
            if ($result === $expected) {
                echo "  ✓ $num: " . ($result ? 'совершенное' : 'не совершенное') . "\n";
                $passed++;
            } else {
                echo "  ✗ $num: получено " . ($result ? 'совершенное' : 'не совершенное') . 
                     ", ожидалось " . ($expected ? 'совершенное' : 'не совершенное') . "\n";
            }
        }
        echo "  Результат: $passed/" . count($tests) . " тестов пройдено\n\n";
    }
    
    private static function testMostRecent(): void
    {
        echo "Тест mostRecent():\n";
        $tests = [
            ['hello world hello', 'hello'],
            ['раз два три два', 'два'],
            ['', null],
        ];
        
        $passed = 0;
        foreach ($tests as [$text, $expected]) {
            try {
                $result = TextAnalyzer::mostRecent($text);
                if ($result === $expected) {
                    echo "  ✓ Текст: '$text' → '$result'\n";
                    $passed++;
                } else {
                    echo "  ✗ Текст: '$text' → '$result' (ожидалось: '$expected')\n";
                }
            } catch (\Exception $e) {
                echo "  ✗ Ошибка: " . $e->getMessage() . "\n";
            }
        }
        echo "  Результат: $passed/" . count($tests) . " тестов пройдено\n\n";
    }
}

// Запуск тестов
SimpleTest::run();
?>