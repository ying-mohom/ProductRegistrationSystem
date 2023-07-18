<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Define validation rules and custom messages for excel register Form
 * @author YingMoHom
 * @create 05/07/2023
 */

class ExcelRegisterRequest extends FormRequest
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
            'file' => 'required|mimes:xls,xlsx|max:10000',      
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
            'file.required' => 'File is required!',
            'file.mimes' => 'File must be Excel File!',
            'file.max' => 'Maximum file size to upload is 10MB',
        ];
    }
}
