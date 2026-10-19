<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(
            $this->user()?->role,
            ['admin', 'manager'],
            true
        );
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'array'],
            'name.ru' => ['required_with:name', 'string', 'max:255'],
            'name.en' => ['required_with:name', 'string', 'max:255'],
            'version' => ['sometimes', 'required', 'string', 'max:255'],
            'image' => ['sometimes', 'nullable', 'string', 'max:255'],
            'short_description' => ['sometimes', 'required', 'array'],
            'short_description.ru' => ['required_with:short_description', 'string'],
            'short_description.en' => ['required_with:short_description', 'string'],
            'full_description' => ['sometimes', 'required', 'array'],
            'full_description.ru' => ['required_with:full_description', 'string'],
            'full_description.en' => ['required_with:full_description', 'string'],
        ];
    }
}
