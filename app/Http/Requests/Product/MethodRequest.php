<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'ut_method' => ['required', 'boolean'],
            'et_method' => ['required', 'boolean'],
            'mia_method' => ['required', 'boolean'],
            'iet_method' => ['required', 'boolean'],
            'mt_method' => ['required', 'boolean'],
            'vt_method' => ['required', 'boolean'],
        ];
    }
}
