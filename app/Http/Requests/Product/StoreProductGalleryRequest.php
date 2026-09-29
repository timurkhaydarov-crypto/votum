<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductGalleryRequest extends FormRequest
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
            'token' => [
                'required',
                'string',
                'max:255',
            ],

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
        ];
    }
}
