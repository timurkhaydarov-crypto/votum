<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FeaturesGalleryRequest extends FormRequest
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
            'features_id' => ['required', 'exists:features,id'],
            'title' => ['required', 'array'],
            'title.ru' => ['required', 'string'],
            'title.en' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
        ];
    }
}
