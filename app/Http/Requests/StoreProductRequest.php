<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama produk wajib diisi',
            'price.min' => 'Harga tidak boleh negatif'
        ];
    }
}
