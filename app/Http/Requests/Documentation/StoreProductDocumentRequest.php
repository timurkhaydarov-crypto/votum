<?php

namespace App\Http\Requests\Documentation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(
            $this->user()?->role,
            ['admin', 'manager'],
            true
        );
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                'max:100',
            ],

            'title' => [
                'required',
                'array',
            ],

            'title.ru' => [
                'required',
                'string',
            ],

            'title.en' => [
                'required',
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

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}