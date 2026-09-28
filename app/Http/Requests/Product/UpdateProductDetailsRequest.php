<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_description' => [
                'required',
                'array',
            ],

            'full_description.ru' => [
                'required',
                'string',
            ],

            'full_description.en' => [
                'required',
                'string',
            ],
        ];
    }
}

