<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDiscountPrice implements Rule
{
    public function passes($attribute, $value)
    {
        $price = request('price');
        $discount = $value;
        $type = request('discount')['type'];

        if ($type === 'fixed') {
            $discount = request('discount')['value'];
        }

        return !($price - $discount < 0);
    }

    public function message()
    {
        return 'The discounted price must be greater than or equal to 0.';
    }
}
