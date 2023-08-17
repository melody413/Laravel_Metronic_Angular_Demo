<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MySQLRequest extends FormRequest
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
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_username' => 'required',
            'db_name' => 'required',
            'db_password' => 'required',
            'confirm_pass' => 'required|same:db_password'
        ];
    }
}
