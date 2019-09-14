<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\interfaces\OperationLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperationLogController extends Controller
{
    protected $operationLogRepository;

    public function __construct(OperationLogRepository $operationLogRepository)
    {
        $this->operationLogRepository = $operationLogRepository;
    }

    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.operation_log.index');
    }

    public function data(Request $request)
    {
        $limit = $request->get('limit', 10);
        $res = $this->operationLogRepository->with(['admin' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('created_at','desc')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '请求成功',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }
}
