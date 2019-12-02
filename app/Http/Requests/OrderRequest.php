<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'created_at' => 'required|date',
            'status' => 'required',
            'total' => 'required|gt:0',
            'buyer' => 'required',
            'buyer.id' => 'required|exists:customers,id',
            'buyer.name' => 'required|max:255',
            'buyer.cpf' => 'required|cpf',
            'buyer.email' => 'required|email',
            'items' => 'required',
            'items.*.amount' => 'required|gt:0',
            'items.*.price_unit' => 'required|gt:0',
            'items.*.total' => 'required|gt:0',
            'items.*.product' => 'required',
            'items.*.product.id' => 'required|exists:products,id',
            'items.*.product.sku' => 'required|exists:products,sku',
            'items.*.product.title' => 'required|exists:products,name|max:255',
        ];
    }
}
