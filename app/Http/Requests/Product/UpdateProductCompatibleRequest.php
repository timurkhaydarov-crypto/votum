<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCompatibleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'compatible_product_ids' => [
                'required',
                'array',
            ],

            'compatible_product_ids.*' => [
                'integer',
                'exists:products,id',
            ],
        ];
    }
}

