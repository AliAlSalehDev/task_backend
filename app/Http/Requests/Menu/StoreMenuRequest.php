<?php

namespace App\Http\Requests\Menu;

use App\Enums\DiscountTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
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
            'discount' => ['nullable', 'array'],
            'discount*.name' => ['required_with:discount', 'string', 'max:100'],
            'discount*.value' => ['required_with:discount', 'integer'],
            'discount*.type' => ['required_with:discount', Rule::in(DiscountTypeEnum::names())]
        ];
    }
}
