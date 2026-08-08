<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'article' => ['required', 'string'],
            'name' => ['required', 'array'],
            'name.ru' => ['required', 'string'],
            'name.en' => ['required', 'string'],
            'short_description' => ['required', 'array'],
            'short_description.ru' => ['required', 'string'],
            'short_description.en' => ['required', 'string'],
            'full_description' => ['required', 'array'],
            'full_description.ru' => ['required', 'string'],
            'full_description.en' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'unit' => ['required', 'string'],
            'price' => ['nullable', 'numeric'],
            'quantity' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
            'note' => ['nullable', 'array'],
            'note.ru' => ['nullable', 'string'],
            'note.en' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string'],
        ];
    }
}
