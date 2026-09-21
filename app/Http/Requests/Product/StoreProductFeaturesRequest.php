<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFeaturesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'features' => [
                'required',
                'array',
            ],

            'features.ru' => [
                'required',
                'string',
            ],

            'features.en' => [
                'required',
                'string',
            ],
        ];
    }
}