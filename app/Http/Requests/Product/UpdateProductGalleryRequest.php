<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(
            $this->user()?->role,
            ['admin', 'manager'],
            true
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'array',
            ],

            'title.ru' => [
                'required_with:title',
                'string',
                'max:255',
            ],

            'title.en' => [
                'required_with:title',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'array',
            ],

            'description.ru' => [
                'nullable',
                'string',
            ],

            'description.en' => [
                'nullable',
                'string',
            ],
        ];
    }
}
