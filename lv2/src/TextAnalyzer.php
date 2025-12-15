<?php
declare(strict_types=1);

namespace App\Utils;

class TextAnalyzer
{
    public static function mostRecent(string $text): ?string
    {
        if (strlen($text) > 1000) {
            throw new \InvalidArgumentException('Текст должен содержать не более 1000 символов');
        }
        
        if (trim($text) === '') {
            return null;
        }
        
        $text = mb_strtolower(trim($text), 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $text = preg_replace('/\s+/u', ' ', $text);
        
        $words = explode(' ', $text);
        $frequency = [];
        
        foreach ($words as $word) {
            if ($word !== '') {
                $frequency[$word] = ($frequency[$word] ?? 0) + 1;
            }
        }
        
        if (empty($frequency)) {
            return null;
        }
        
        arsort($frequency);
        return array_key_first($frequency);
    }
}
?>