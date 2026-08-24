<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductGalleryRequest extends FormRequest
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
            'title' => ['required', 'array'],
            'title.ru' => ['required', 'string'],
            'title.en' => ['required', 'string'],
            'description' => ['required', 'array'],
            'description.ru' => ['required', 'string'],
            'description.en' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
        ];
    }
}
