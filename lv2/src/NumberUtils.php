<?php
declare(strict_types=1);

namespace App\Utils;

class NumberUtils
{
    public static function isPerfectNumber(int $num): bool
    {
        if ($num <= 0) return false;
        
        $sum = 0;
        for ($i = 1; $i <= $num / 2; $i++) {
            if ($num % $i === 0) {
                $sum += $i;
            }
        }
        return $sum === $num;
    }
    
    public static function findFirstPerfectNumber(array $numbers): ?int
    {
        foreach ($numbers as $num) {
            if (self::isPerfectNumber($num)) {
                return $num;
            }
        }
        return null;
    }
}
?>