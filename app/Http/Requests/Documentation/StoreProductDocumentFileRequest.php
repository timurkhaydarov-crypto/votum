<?php

namespace App\Http\Requests\Documentation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductDocumentFileRequest extends FormRequest
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
            'locale' => [
                'required',
                'string',
                'in:ru,en',
            ],

            'file' => [
                'required',
                'file',
                'mimetypes:application/pdf',
                'extensions:pdf',
                'max:51200',
            ],
        ];
    }
}