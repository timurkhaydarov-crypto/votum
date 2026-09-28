<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && in_array(auth()->user()->role, ['admin', 'manager'], true);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'nullable',
                'array',
            ],

            'title.ru' => [
                'nullable',
                'string',
            ],

            'title.en' => [
                'nullable',
                'string',
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