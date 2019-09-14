<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Icon;
use App\Http\Controllers\Controller;
use App\Repositories\interfaces\ConfigRepository;


class IndexController extends Controller
{

    public function layout(ConfigRepository $configRepository)
    {
        $site = $configRepository->cacheConfig('site');
        return view('admin.layout', compact('site'));
    }

    public function index()
    {

        return 1;
    }

    public function index2()
    {
        return 'index2';
    }

    public function index3()
    {
        return 'index3';
    }

    public function icons()
    {
        $icons = Icon::orderBy('sort', 'desc')->get();
        return response()->json(['code' => 0, 'msg' => '请求成功', 'data' => $icons]);
    }
}
