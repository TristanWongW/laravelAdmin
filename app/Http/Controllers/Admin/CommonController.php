<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    /**
     * 更新排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSort(Request $request)
    {
        $table = $request->get('table', '');
        $id_name = $request->get('id_name', '');
        $id_value = $request->get('id_value', '');
        $field = $request->get('field', '');
        $value = intval($request->get('value'));

        if ($table == '' || $id_name == '' || $id_value == '' || $field == '') {
            return response()->json(['code' => 1001, 'msg' => '传递参数错误']);
        }
        $r = DB::table($table)->where($id_name, $id_value)->update([$field => $value]);
        return response()->json($this->backJsonMsg($r !== false));
    }

    /**
     * 更新表中某一个字段
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeTableVal(Request $request)
    {
        $table = $request->get('table', '');
        $id_name = $request->get('id_name', '');
        $id_value = $request->get('id_value', '');
        $field = $request->get('field', '');
        $value = $request->get('value', '');

        if ($table == '' || $id_name == '' || $id_value == '' || $field == '' || $value == '') {
            return response()->json(['code' => 1001, 'msg' => '传递参数错误']);
        }
        $r = DB::table($table)->where($id_name, $id_value)->update([$field => $value]);
        return response()->json($this->backJsonMsg($r !== false));
    }

}
