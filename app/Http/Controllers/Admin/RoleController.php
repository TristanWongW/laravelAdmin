<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Repositories\interfaces\PermissionRepository;
use App\Repositories\interfaces\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * 列表页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.role.index');
    }

    public function data(Request $request)
    {
        $limit = $request->get('limit', 10);
        $res = $this->roleRepository->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '请求成功',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 添加操作
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.create');
    }

    public function store(RoleCreateRequest $createRequest)
    {
        $r = $this->roleRepository->create($createRequest->except('_token'));
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 编辑操作
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(RoleUpdateRequest $updateRequest, $id)
    {
        $r = $this->roleRepository->update($updateRequest->except('_token'), $id);
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 删除操作
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return response()->json(['code' => 1, 'msg' => '请选择删除项']);
        }
        if (Role::destroy($ids)) {
            return response()->json(['code' => 0, 'msg' => '删除成功']);
        }
        return response()->json(['code' => 1, 'msg' => '删除失败']);
    }

    /**
     * 分配权限
     */
    public function permission(Request $request, $id, PermissionRepository $permissionRepository)
    {
        $role = $this->roleRepository->find($id);
        $permissions = $permissionRepository->tree();
        foreach ($permissions as $key1 => $item1) {
            $permissions[$key1]['own'] = $role->hasPermissionTo($item1['id']) ? 'checked' : false;
            if (isset($item1['_child'])) {
                foreach ($item1['_child'] as $key2 => $item2) {
                    $permissions[$key1]['_child'][$key2]['own'] = $role->hasPermissionTo($item2['id']) ? 'checked' : false;
                    if (isset($item2['_child'])) {
                        foreach ($item2['_child'] as $key3 => $item3) {
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $role->hasPermissionTo($item3['id']) ? 'checked' : false;
                        }
                    }
                }
            }
        }
        return view('admin.role.permission', compact('role', 'permissions'));
    }

    /**
     * 存储权限
     */
    public function assignPermission(Request $request, $id)
    {
        $role = $this->roleRepository->find($id);
        $permissions = $request->get('permissions');
        if (empty($permissions)) {
            $role->permissions()->detach();
        } else {
            $role->syncPermissions($permissions);
        }
        return response()->json(['code' => 0, 'msg' => '已更新角色权限']);
    }
}
