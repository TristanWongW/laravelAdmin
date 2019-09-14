<?php

namespace App\Http\Controllers\admin;

use App\Entities\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    //

    public function index()
    {

        return view('admin.wechat.index');
    }

    public function data(Wechat $wechatModel, Request $request)
    {
        $limit = $request->get('limit', 10);
        $data = $wechatModel->paginate($limit)->toarray();
        return response()->json($this->formateListData($data));
    }

    public function create()
    {
        return view('admin.wechat.create');
    }

    public function store()
    {

    }

}
