<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductAppRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.ru' => ['required', 'string', 'max:255'],
            'name.en' => ['required', 'string', 'max:255'],
            'version' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'short_description' => ['required', 'array'],
            'short_description.ru' => ['required', 'string'],
            'short_description.en' => ['required', 'string'],
            'full_description' => ['required', 'array'],
            'full_description.ru' => ['required', 'string'],
            'full_description.en' => ['required', 'string'],
            'image_tokens' => ['sometimes', 'array', 'max:20'],
            'image_tokens.*' => ['required', 'string', 'max:255', 'distinct'],
        ];
    }
}
