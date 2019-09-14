<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogged;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('admin.login_register.login');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha'
        ], [
            'captcha.required' => '验证码必须',
            'captcha.captcha' => '验证码不正确'
        ]);
    }

    public function username()
    {
        return 'name';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function redirectTo()
    {
        $this->setAdminLogData();
        return route('admin.layout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin');
    }

    protected function setAdminLogData()
    {
        $data = [
            'admin_id' => $this->guard()->user()->id,
            'ip' => \request()->getClientIp(),
            //'address' => getIpLookup(\request()->getClientIp())
        ];
        event(new AdminLogged($data));
    }
}
