<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Define validation rules and custom messages for normal register input request
 * @author YingMoHom
 * @create 21/06/2023
 */

class NormalRegisterRequest extends FormRequest
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
            'itemId' => 'required',
            'itemCode' => 'required',
            'itemName' => 'required',
            'categoryId' => 'required',
            'safetyStock' => 'required|numeric',
            'receivedDate' => 'required',
            'categoryId'   => 'required',
            'file' => 'mimes:jpeg,png,jpg',
            'description' => 'max:5000',

        ];
    }
    /**
     * Get the validation custom messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'itemId.required' => 'The Item ID  is required!',
            'itemCode.required' => 'The Item Code  is required!',
            'itemName.required' => 'The Item Name  is required!',
            'categoryId.required' => 'The Category Name  is required!',
            'safetyStock.required' => 'The safety Stock  is required!',
            'safetyStock.numeric' => 'The safety Stock must be integer!',
            'receivedDate.required' => 'Received Date is required!',
            'categoryId.required'   => 'Category is required!',
            'description.max'       => 'The description must not exceed 5000 characters.'

        ];
    }
}
