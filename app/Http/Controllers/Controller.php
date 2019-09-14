<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function backJsonMsg($r, $data = '', $code = '', $msg = '')
    {
        if ($code != '' && $msg == '') {
            return ['code' => $code, 'msg' => $r ? '操作成功' : '操作失败', 'data' => $data];
        }

        if ($code == '' && $msg != '') {
            return ['code' => $r ? 0 : 1001, 'msg' => $msg, 'data' => $data];
        }

        if ($code == '' && $msg == '') {
            return ['code' => $r ? 0 : 1001, 'msg' => $r ? '操作成功' : '操作失败', 'data' => $data];
        }
    }

    /**
     * 格式是分页列表数据
     * @param $data
     * @return array
     */
    public function formateListData($data)
    {
        return [
            'code' => 0,
            'msg' => '请求成功',
            'count' => $data['total'],
            'data' => $data['data']
        ];
    }
}
