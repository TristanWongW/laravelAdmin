<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Admin;
use App\Entities\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminPasswordRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Repositories\interfaces\AdminRepository;
use App\Repositories\interfaces\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.admin.index');
    }

    public function data(Request $request)
    {
        $limit = $request->get('limit', 10);
        $res = $this->adminRepository->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '请求成功',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 添加管理员
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(AdminCreateRequest $createRequest)
    {
        $data = $createRequest->except(['_token', 'password_confirmation']);
        $data['password'] = bcrypt($data['password']);
        $r = $this->adminRepository->create($data);
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 编辑管理员
     */
    public function edit($id)
    {
        $admin = $this->adminRepository->find($id);
        return view('admin.admin.edit', compact('admin'));
    }

    public function update(AdminUpdateRequest $updateRequest, $id)
    {
        $data = $updateRequest->except(['_token', 'password_confirmation']);
        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $r = $this->adminRepository->update($data, $id);
        return response()->json($this->backJsonMsg($r));
    }

    /**
     * 删除管理员
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return response()->json(['code' => 1001, 'msg' => '请选择删除项']);
        }
        if (Admin::destroy($ids)) {
            return response()->json(['code' => 0, 'msg' => '删除成功']);
        }
        return response()->json(['code' => 1001, 'msg' => '删除失败']);
    }

    /**
     * 分配角色
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role($id)
    {
        $admin = $this->adminRepository->find($id);
        $roles = Role::all();
        foreach ($roles as $role) {
            $role->own = $admin->hasRole($role) ? true : false;
        }
        return view('admin.admin.role', compact('admin', 'roles'));
    }

    public function assignRole(Request $request, $id)
    {
        $admin = $this->adminRepository->find($id);
        $roles = $request->post('roles', []);
        if ($admin->syncRoles($roles)) {
            return response()->json(['code' => 0, 'msg' => '更新用户角色成功']);
        } else {
            return response()->json(['code' => 1001, 'msg' => '系统错误']);
        }
    }

    /**
     * 直接分配权限
     * @param PermissionRepository $permissionRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission(PermissionRepository $permissionRepository, $id)
    {
        $admin = $this->adminRepository->find($id);
        $permissions = $permissionRepository->tree();
        foreach ($permissions as $key1 => $item1) {
            $permissions[$key1]['own'] = $admin->hasDirectPermission($item1['id']) ? 'checked' : false;
            if (isset($item1['_child'])) {
                foreach ($item1['_child'] as $key2 => $item2) {
                    $permissions[$key1]['_child'][$key2]['own'] = $admin->hasDirectPermission($item2['id']) ? 'checked' : false;
                    if (isset($item2['_child'])) {
                        foreach ($item2['_child'] as $key3 => $item3) {
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $admin->hasDirectPermission($item3['id']) ? 'checked' : false;
                        }
                    }
                }
            }
        }
        return view('admin.admin.permission', compact('admin', 'permissions'));
    }

    public function assignPermission(Request $request, $id)
    {
        $admin = $this->adminRepository->find($id);
        $permissions = $request->post('permissions', []);
        $r = $admin->syncPermissions($permissions);
        if ($r) {
            return response()->json(['code' => 0, 'msg' => '更新权限成功']);
        } else {
            return response()->json(['code' => 1001, 'msg' => '系统错误']);
        }
    }

    /**
     * 修改基本信息
     */
    public function password()
    {
        return view('admin.admin.password');
    }

    public function resetPassword(AdminPasswordRequest $passwordRequest)
    {
        $data = $passwordRequest->except(['_token', '_method']);
        $admin = Auth::guard('admin')->user();
        if (Hash::check($data['password_old'], $admin->password)) {
            $r = $this->adminRepository->update(['password' => bcrypt($data['password'])], $admin->id);
            if ($r) {
                Auth::guard('admin')->logout();
            }
            return response()->json($this->backJsonMsg($r));
        } else {
            return response()->json(['code' => 1001, 'msg' => '原始密码不正确']);
        }
    }
}
