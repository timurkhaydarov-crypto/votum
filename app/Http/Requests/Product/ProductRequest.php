<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            /*
            |--------------------------------------------------------------------------
            | Basic product data
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
            | Classification
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

            'group_ids' => [
                'nullable',
                'array',
            ],

            'group_ids.*' => [
                'integer',
                'exists:groups,id',
            ],

            'brand_id' => [
                'required',
                'integer',
                'exists:brands,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Commercial data
            |--------------------------------------------------------------------------
            */
            'unit' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'nullable',
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
            | Additional information
            |--------------------------------------------------------------------------
            */
            'note' => [
                'nullable',
                'array',
            ],

            'note.ru' => [
                'nullable',
                'string',
            ],

            'note.en' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */
            'image_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'video_url' => [
                'nullable',
                'string',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Certificates
            |--------------------------------------------------------------------------
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
            */
            'compatible_product_ids' => [
                'nullable',
                'array',
            ],

            'compatible_product_ids.*' => [
                'integer',
                'exists:products,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Methods
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
            | Sectors
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
            | Gallery
            |--------------------------------------------------------------------------
            */
            'gallery' => [
                'nullable',
                'array',
            ],

            'gallery.*.title' => [
                'nullable',
                'array',
            ],

            'gallery.*.title.ru' => [
                'nullable',
                'string',
            ],

            'gallery.*.title.en' => [
                'nullable',
                'string',
            ],

            'gallery.*.image_url' => [
                'required',
                'string',
                'max:255',
            ],

            'gallery.*.description' => [
                'nullable',
                'array',
            ],

            'gallery.*.description.ru' => [
                'nullable',
                'string',
            ],

            'gallery.*.description.en' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Features
            |--------------------------------------------------------------------------
            */
            'features' => [
                'nullable',
                'array',
            ],

            'features.ru' => [
                'nullable',
                'string',
            ],

            'features.en' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Features gallery
            |--------------------------------------------------------------------------
            */
            'features_gallery' => [
                'nullable',
                'array',
            ],

            'features_gallery.*.title' => [
                'nullable',
                'array',
            ],

            'features_gallery.*.title.ru' => [
                'nullable',
                'string',
            ],

            'features_gallery.*.title.en' => [
                'nullable',
                'string',
            ],

            'features_gallery.*.image_url' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Specifications
            |--------------------------------------------------------------------------
            */
            'specifications' => [
                'nullable',
                'array',
            ],

            'specifications.*.name' => [
                'required',
                'array',
            ],

            'specifications.*.name.ru' => [
                'required',
                'string',
            ],

            'specifications.*.name.en' => [
                'required',
                'string',
            ],

            'specifications.*.value' => [
                'required',
                'array',
            ],

            'specifications.*.value.ru' => [
                'required',
                'string',
            ],

            'specifications.*.value.en' => [
                'required',
                'string',
            ],
        ];
    }
}