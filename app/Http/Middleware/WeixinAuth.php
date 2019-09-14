<?php

namespace App\Http\Middleware;

use App\Entities\Config;
use Closure;
use EasyWeChat\Factory;

class WeixinAuth
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $wx_user = session('wx_user');
        if (!$wx_user) {
            $configModel = new Config();
            $wx_config = $configModel->getCache('wx');
            if ($wx_config['oauth_type'] == 1) {// 直接授权
                return $this->redirectAuth($request, $wx_config);
            } elseif ($wx_config['oauth_type'] == 2) {// 通过第三方传递code授权
                return $this->codeAuth($request, $wx_config);
            }
        }
        return $next($request);
    }

    /**
     * 直接授权
     * @param $request
     * @param $wx_config
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectAuth($request, $wx_config)
    {
        $config = [
            'app_id' => $wx_config['appId'],
            'secret' => $wx_config['appSecret'],
            'response_type' => 'array',
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => route('wx.auth'),
            ],
        ];
        $request->session()->put('target_url', $request->fullUrl());
        $wx_app = Factory::officialAccount($config);
        $oauth = $wx_app->oauth;
        return $oauth->redirect();
    }

    /**
     * code 授权
     * @param $request
     * @param $wx_config
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function codeAuth($request, $wx_config)
    {
        $oauth_url = $wx_config['oauth_url'];
        $request->session()->put('target_url', $request->fullUrl());
        return redirect($oauth_url);
    }

}
