<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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

    public function validationData()
    {
        $all = parent::validationData();
        
        if(isset($all['cpf']) && !empty($all['cpf']))
            $all['cpf'] = preg_replace("/[^0-9]/", "", $all['cpf']);

        return $all;
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
            'name' => 'required|max:255',
            'email' => 'required|unique:customers|email|max:255',
            'cpf' => 'required|unique:customers|cpf',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];
    }
}
