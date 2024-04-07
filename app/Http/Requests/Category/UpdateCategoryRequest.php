<?php

namespace App\Http\Requests\Category;

use App\Enums\DiscountTypeEnum;
use App\Rules\MaxSubcategoryLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', new MaxSubcategoryLevel],
            'menu_id' => ['required', 'integer', 'exists:menus,id'],
            'discount' => ['nullable', 'array'],
            'discount*.id' => ['required_with:discount', 'integer', 'exists:discounts,id'],
            'discount*.name' => ['required_with:discount', 'string', 'max:100'],
            'discount*.value' => ['required_with:discount', 'integer'],
            'discount*.type' => ['required_with:discount', Rule::in(DiscountTypeEnum::names())]
        ];
    }
}
