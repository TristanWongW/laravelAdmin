<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Repositories\interfaces\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        return view('admin.permission.index');
    }

    public function data()
    {
        $trees = $this->permissionRepository->tree([], 'id', 'parent_id', 'children', 0);
        $data = [
            'code' => 0,
            'msg' => '请求成功',
            'data' => $trees
        ];
        return response()->json($data);
    }

    /**
     * 添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->permissionRepository->tree();
        return view('admin.permission.create', compact('permissions'));
    }

    public function store(PermissionCreateRequest $createRequest)
    {
        $r = $this->permissionRepository->create($createRequest->except('_token'));
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $permission = $this->permissionRepository->find($id);
        $permissions = $this->permissionRepository->tree();
        return view('admin.permission.edit', compact('permission', 'permissions'));
    }

    public function update(PermissionUpdateRequest $updateRequest, $id)
    {
        $r = $this->permissionRepository->update($updateRequest->except('_token'), $id);
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 删除操作
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id','');
        if ($id == '') {
            return response()->json(['code' => 1, 'msg' => '请选择删除项']);
        }
        $permission = $this->permissionRepository->find($id);
        if (!$permission) {
            return response()->json(['code' => -1, 'msg' => '权限不存在']);
        }
        //如果有子权限，则禁止删除
        if (count($this->permissionRepository->findWhere(['parent_id' => $id])) > 0) {
            return response()->json(['code' => 2, 'msg' => '存在子权限禁止删除']);
        }

        if ($permission->delete()) {
            return response()->json(['code' => 0, 'msg' => '删除成功']);
        }
        return response()->json(['code' => 1, 'msg' => '删除失败']);

    }
}
