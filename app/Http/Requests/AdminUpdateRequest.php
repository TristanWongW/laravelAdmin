<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
        $rule = [
            'phone' => 'required|numeric|regex:/^1[3456789][0-9]{9}$/',
            'name' => 'required|min:1|max:16|unique:admins,name,' . $this->route('id') . ',id',
            'nickname' => 'required|max:191',
            'email' => 'required|E-Mail|max:191|unique:admins,email,' . $this->route('id') . ',id',
        ];

        if ($this->post('password') || $this->post('password_confirmation')) {
            $rule['password'] = [
                'required',
                'confirmed',
                'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/'
            ];
            $rule['password_confirmation'] = 'required|same:password';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'name.unique' => '该用户名已经存在',
            'password.regex' => '密码必须包含字母和数字,长度6-20之间'
        ];
    }
}
