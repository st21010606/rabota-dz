<?php
declare(strict_types=1);

namespace App\Utils;

class StringUtils
{
    public static function alphabeticalOrder(string $str): string
    {
        $chars = str_split($str);
        sort($chars);
        return implode('', $chars);
    }
}
?>