<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\interfaces\AdminLogRepository;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    protected $adminLogRepository;

    public function __construct(AdminLogRepository $adminLogRepository)
    {
        $this->adminLogRepository = $adminLogRepository;
    }

    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.admin_log.index');
    }

    public function data(Request $request)
    {
        $limit = $request->get('limit', 10);
        $res = $this->adminLogRepository->with(['admin' => function ($query) {
            $query->select('id', 'name');
        }])->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '请求成功',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }
}
