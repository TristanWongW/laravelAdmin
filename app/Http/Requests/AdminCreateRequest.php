<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
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
            'phone' => 'required|numeric|regex:/^1[3456789][0-9]{9}$/',
            'name' => 'required|min:1|max:16|unique:admins',
            'nickname' => 'required|max:191',
            'email' => 'required|E-Mail|max:191|unique:admins',
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/'
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '该用户名已经存在',
            'password.regex' => '密码必须包含字母和数字,长度6-20之间'
        ];
    }
}
