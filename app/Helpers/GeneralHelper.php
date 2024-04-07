<?php

use App\Enums\DiscountTypeEnum;

if (! function_exists('formatDecimals')) {
    function formatDecimals($number): string
    {
        return number_format((float)$number, 2, '.', '');
    }
}

if (! function_exists('calculateDiscount')) {
    function calculateDiscount($discount, $price): string
    {
        $type = $discount->type;
        if($type == 'percentage') {
            $price = $price - ($price * $discount->value / 100);
        } elseif($type == 'fixed') {
            $price = $price - $discount->value;
        }
        return formatDecimals($price);
    }
}

