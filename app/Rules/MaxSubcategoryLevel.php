<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Category;

class MaxSubcategoryLevel implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === null) {
            return true;
        }

        $category = Category::find($value);

        if ($category === null) {
            return false;
        }

        $level = 1;
        while ($category->parent_id !== null) {
            $category = $category->parent;
            $level++;
        }

        return $level < 4;
    }

    public function message()
    {
        return 'The maximum number of subcategory levels is 4.';
    }
}
