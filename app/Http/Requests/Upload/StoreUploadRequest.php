<?php

namespace App\Http\Requests\Upload;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUploadRequest extends FormRequest
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
        $type = $this->input('type');

        $fileRules = [
            'required',
            'file',
        ];

        if ($type === 'image') {
            $fileRules = [
                ...$fileRules,
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:20480',
            ];
        }

        if ($type === 'video') {
            $fileRules = [
                ...$fileRules,
                'mimes:mp4,webm,mov',
                'max:512000',
            ];
        }

        return [
            'type' => [
                'required',
                Rule::in([
                    'image',
                    'video',
                ]),
            ],

            'file' => $fileRules,
        ];
    }
}