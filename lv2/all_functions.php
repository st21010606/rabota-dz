<?php

echo "=== ТЕСТ ВСЕХ ТРЕХ ФУНКЦИЙ ===\n\n";

// 1. Функция сортировки строки
function alphabeticalOrder($str) {
    $chars = str_split($str);
    sort($chars);
    return implode('', $chars);
}

// 2. Функция поиска идеального числа
function findPerfectNumber($arr) {
    $isPerfect = function($num) {
        if ($num <= 1) return false;
        
        $divisorsSum = 1;
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                $divisorsSum += $i;
                if ($i != $num / $i) {
                    $divisorsSum += $num / $i;
                }
            }
        }
        return $divisorsSum == $num;
    };
    
    foreach ($arr as $num) {
        if ($isPerfect($num)) {
            return $num;
        }
    }
    return null;
}

// 3. Функция поиска самого частого слова
function mostRecent($text) {
    if (strlen($text) > 1000) {
        return "Ошибка: текст слишком длинный";
    }
    
    $words = explode(' ', $text);
    if (empty($words)) return null;
    
    $wordCount = [];
    foreach ($words as $word) {
        $wordClean = strtolower(trim($word, ".,!?;:\"'()[]{}"));
        if (!empty($wordClean)) {
            $wordCount[$wordClean] = isset($wordCount[$wordClean]) 
                ? $wordCount[$wordClean] + 1 
                : 1;
        }
    }
    
    if (empty($wordCount)) return null;
    
    $maxCount = max($wordCount);
    $mostCommonWords = array_keys(array_filter($wordCount, 
        function($count) use ($maxCount) {
            return $count === $maxCount;
        }
    ));
    
    return $mostCommonWords[0] ?? null;
}

// ===== ТЕСТИРОВАНИЕ =====
echo "1. ТЕСТ alphabeticalOrder:\n";
echo "   Вход: 'alphabetical'\n";
echo "   Результат: " . alphabeticalOrder('alphabetical') . "\n";
echo "   ✓ Ожидаемый: aaabcehillpt\n\n";

echo "2. ТЕСТ findPerfectNumber:\n";
echo "   Вход: [6, 28, 12, 8, 496]\n";
echo "   Результат: " . findPerfectNumber([6, 28, 12, 8, 496]) . "\n";
echo "   ✓ Ожидаемый: 6\n\n";

echo "3. ТЕСТ mostRecent:\n";
$text = "Hello world hello everyone world world";
echo "   Вход: '$text'\n";
echo "   Результат: " . mostRecent($text) . "\n";
echo "   ✓ Ожидаемый: world\n\n";

echo "=== ДОПОЛНИТЕЛЬНЫЕ ТЕСТЫ ===\n\n";

echo "4. Тест с коротким текстом:\n";
echo "   mostRecent('a b c a b a'): " . mostRecent('a b c a b a') . "\n\n";

echo "5. Тест с пустым массивом:\n";
echo "   findPerfectNumber([]): ";
$result = findPerfectNumber([]);
echo ($result === null ? 'NULL' : $result) . "\n";

echo "\n=== ВСЕ ТЕСТЫ ЗАВЕРШЕНЫ ===\n";