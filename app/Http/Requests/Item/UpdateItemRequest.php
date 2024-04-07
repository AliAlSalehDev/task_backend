<?php

namespace App\Http\Requests\Item;

use App\Enums\DiscountTypeEnum;
use App\Rules\ValidDiscountPrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories,id'],
            'discount' => ['nullable', 'array'],
            'discount*.id' => ['required_with:discount', 'integer', 'exists:discounts,id'],
            'discount*.name' => ['required_with:discount', 'string', 'max:100'],
            'discount*.value' => ['required_with:discount', 'integer', new ValidDiscountPrice()],
            'discount*.type' => ['required_with:discount', Rule::in(DiscountTypeEnum::names())]
        ];
    }
}
