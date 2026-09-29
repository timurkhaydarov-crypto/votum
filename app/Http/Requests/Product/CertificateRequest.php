<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'array',
            ],

            'title.ru' => [
                'required',
                'string',
                'max:255',
            ],

            'title.en' => [
                'required',
                'string',
                'max:255',
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

            'image' => [
                $this->isMethod('post')
                    ? 'required'
                    : 'nullable',

                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ];
    }
}
