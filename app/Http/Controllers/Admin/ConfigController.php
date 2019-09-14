<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\interfaces\ConfigRepository;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    protected $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * 网站配置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function site()
    {
        $site = $this->configRepository->cacheConfig('site');
        return view('admin.config.site', compact('site'));
    }

    public function siteUpdate(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $site = $this->configRepository->cacheConfig('site', $data);
        return response()->json($this->backJsonMsg($site));
    }

    /**
     * 微信配置
     */
    public function wx()
    {
        $wx = $this->configRepository->cacheConfig('wx');
        return view('admin.config.wx', compact('wx'));
    }

    public function wxUpdate(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $wx = $this->configRepository->cacheConfig('wx', $data);
        return response()->json($this->backJsonMsg($wx));
    }

    /**
     * 蜀信e配置
     */
    public function shx()
    {
        $shx = $this->configRepository->cacheConfig('shx');
        return view('admin.config.shx', compact('shx'));
    }

    public function shxUpdate(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $shx = $this->configRepository->cacheConfig('shx', $data);
        return response()->json($this->backJsonMsg($shx));
    }
}
