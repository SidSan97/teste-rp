<?php
namespace App\Utils;

class GenerateSkuUtility 
{
    public static function generateSKU() {
        $prefix = 'SKU';
        $random = strtoupper(substr(md5(uniqid()), 0, 8));

        return "{$prefix}-{$random}";
    }
}