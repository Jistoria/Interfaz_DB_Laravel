<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'product_name' => 'required',
            'description_product' => 'required',
            'price' => 'required|numeric',
            'image' => 'required',
            'quantity' => 'required|integer',
            'id_product_brand' => 'required|exists:product_brand,id_product_brand',
            'id_component' => 'required|exists:component,id_component',
        ];
    }
}
