<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductSpecificationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'array'],
            'name.ru' => ['required', 'string'],
            'name.en' => ['required', 'string'],
            'value' => ['required', 'array'],
            'value.ru' => ['required', 'string'],
            'value.en' => ['required', 'string'],
        ];
    }
}
