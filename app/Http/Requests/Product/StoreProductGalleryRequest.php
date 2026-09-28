<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && in_array(auth()->user()->role, ['admin', 'manager'], true);
    }

    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:102400',
            ],

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

            'description' => [
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