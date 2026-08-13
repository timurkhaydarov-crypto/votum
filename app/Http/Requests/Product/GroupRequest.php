<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'group' => ['required', 'array'],
            'group.ru' => ['required', 'string'],
            'group.en' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'description' => ['required', 'array'],
            'description.ru' => ['required', 'string'],
            'description.en' => ['required', 'string']
        ];
    }
}
