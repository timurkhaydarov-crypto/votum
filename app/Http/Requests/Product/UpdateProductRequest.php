<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * These values are controlled by the application
     * and are not editable through the form.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'unit' => 'pcs',
            'brand_id' => 1,
            'price' => 0,
            'quantity' => 10,
            'status' => true,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Primary product data + product relations.
     */
    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Basic information
            |--------------------------------------------------------------------------
            */

            'article' => [
                'required',
                'string',
                'max:255',
            ],

            'name' => [
                'required',
                'array',
            ],

            'name.ru' => [
                'required',
                'string',
            ],

            'name.en' => [
                'required',
                'string',
            ],

            'short_description' => [
                'required',
                'array',
            ],

            'short_description.ru' => [
                'required',
                'string',
            ],

            'short_description.en' => [
                'required',
                'string',
            ],

            'full_description' => [
                'required',
                'array',
            ],

            'full_description.ru' => [
                'required',
                'string',
            ],

            'full_description.en' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Main category and group
            |--------------------------------------------------------------------------
            */

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'group_id' => [
                'required',
                'integer',
                'exists:groups,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Hidden product defaults
            |--------------------------------------------------------------------------
            */

            'unit' => [
                'required',
                'string',
                'in:pcs',
            ],

            'brand_id' => [
                'required',
                'integer',
                'exists:brands,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Main image
            |--------------------------------------------------------------------------
            */

            'image_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image_upload_token' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product video
            |--------------------------------------------------------------------------
            */

            'video_url' => [
                'nullable',
                'string',
                'max:2048',
            ],

            'video_upload_token' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Testing methods
            |--------------------------------------------------------------------------
            */

            'method' => [
                'nullable',
                'array',
            ],

            'method.ut_method' => [
                'nullable',
                'boolean',
            ],

            'method.et_method' => [
                'nullable',
                'boolean',
            ],

            'method.mia_method' => [
                'nullable',
                'boolean',
            ],

            'method.iet_method' => [
                'nullable',
                'boolean',
            ],

            'method.mt_method' => [
                'nullable',
                'boolean',
            ],

            'method.vt_method' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Application sectors
            |--------------------------------------------------------------------------
            */

            'sector' => [
                'nullable',
                'array',
            ],

            'sector.railway' => [
                'nullable',
                'boolean',
            ],

            'sector.aerospace' => [
                'nullable',
                'boolean',
            ],

            'sector.oil' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product certificates
            |--------------------------------------------------------------------------
            |
            | These fields are optional because certificates can also be
            | managed separately through the certificates section.
            |
            */

            'certificate_ids' => [
                'nullable',
                'array',
            ],

            'certificate_ids.*' => [
                'integer',
                'exists:certificates,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Compatible products
            |--------------------------------------------------------------------------
            |
            | These fields are optional. When present, ProductController
            | synchronizes the compatibility relations.
            |
            */

            'compatible_product_ids' => [
                'nullable',
                'array',
            ],

            'compatible_product_ids.*' => [
                'integer',
                'exists:products,id',
            ],
        ];
    }
}