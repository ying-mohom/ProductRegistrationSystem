<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Define validation rules and custom messages for employee login input request
 * @author YingMoHom
 * @create 21/06/2023
 */
class LoginRequest extends FormRequest
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
            'emp_id' => 'required|numeric',
            'emp_pwd' => 'required',
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
            'emp_id.required' => 'Employee ID is required.',
            'emp_id.numeric' => 'Employee ID  must be an integer.',
            'emp_pwd.required' => 'Employee Password  is required.',
        ];
    }
}
