<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'array'],
            'category.ru' => ['required', 'string'],
            'category.en' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'description' => ['required', 'array'],
            'description.ru' => ['required', 'string'],
            'description.en' => ['required', 'string']
        ];
    }
}
