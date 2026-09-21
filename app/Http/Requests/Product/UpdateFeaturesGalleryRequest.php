<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeaturesGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
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
        ];
    }
}