<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清空表
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('admins')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 添加管理员
        $admin = \App\Entities\Admin::create([
            'name' => 'admin',
            'password' => bcrypt('123456'),
            'email' => 'admin@admin.com',
            'phone' => '13966668888',
            'nickname' => '超级管理员',
        ]);

        // 添加角色
        $role = \App\Entities\Role::create([
            'name' => 'admin',
            'display_name' => '超级管理员'
        ]);

        // 添加权限
        $permissions = [
            [
                'name' => 'system.manage',
                'display_name' => '系统管理',
                'route' => '',
                'icon_id' => '100',
                'child' => [
                    [
                        'name' => 'system.admin',
                        'display_name' => '管理员管理',
                        'route' => 'admin.admin',
                        'icon_id' => '123',
                        'child' => [
                            ['name' => 'system.admin.create', 'display_name' => '添加管理员', 'route' => 'admin.admin.create'],
                            ['name' => 'system.admin.edit', 'display_name' => '编辑管理员', 'route' => 'admin.admin.edit'],
                            ['name' => 'system.admin.destroy', 'display_name' => '删除管理员', 'route' => 'admin.admin.destroy'],
                            ['name' => 'system.admin.role', 'display_name' => '分配角色', 'route' => 'admin.admin.role'],
                            ['name' => 'system.admin.permission', 'display_name' => '分配权限', 'route' => 'admin.admin.permission'],
                            ['name' => 'system.index.import', 'display_name' => '导入', 'route' => 'admin.index.import'],
                            ['name' => 'system.index.export', 'display_name' => '导出', 'route' => 'admin.index.export'],
                        ]
                    ],
                    [
                        'name' => 'system.role',
                        'display_name' => '角色管理',
                        'route' => 'admin.role',
                        'icon_id' => '121',
                        'child' => [
                            ['name' => 'system.role.create', 'display_name' => '添加角色', 'route' => 'admin.role.create'],
                            ['name' => 'system.role.edit', 'display_name' => '编辑角色', 'route' => 'admin.role.edit'],
                            ['name' => 'system.role.destroy', 'display_name' => '删除角色', 'route' => 'admin.role.destroy'],
                            ['name' => 'system.role.permission', 'display_name' => '分配权限', 'route' => 'admin.role.permission'],
                        ]
                    ],
                    [
                        'name' => 'system.permission',
                        'display_name' => '权限管理',
                        'route' => 'admin.permission',
                        'icon_id' => '12',
                        'child' => [
                            ['name' => 'system.permission.create', 'display_name' => '添加权限', 'route' => 'admin.permission.create'],
                            ['name' => 'system.permission.edit', 'display_name' => '编辑权限', 'route' => 'admin.permission.edit'],
                            ['name' => 'system.permission.destroy', 'display_name' => '删除权限', 'route' => 'admin.permission.destroy'],
                        ]
                    ],
                    [
                        'name' => 'system.admin_log',
                        'display_name' => '登录日志',
                        'route' => 'admin.admin_log',
                        'icon_id' => '16',
                    ],
                    [
                        'name' => 'system.admin_operation_log',
                        'display_name' => '操作日志',
                        'route' => 'admin.operation_log',
                        'icon_id' => '16',
                    ],

                ]
            ],
            [
                'name' => 'config.manage',
                'display_name' => '配置管理',
                'route' => '',
                'icon_id' => '28',
                'child' => [
                    [
                        'name' => 'config.site',
                        'display_name' => '站点配置',
                        'route' => 'admin.config.site',
                        'icon_id' => '25',
                    ],
//                    [
//                        'name' => 'config.wx',
//                        'display_name' => '微信配置',
//                        'route' => 'admin.config.wx',
//                        'icon_id' => '30',
//                    ],
//                    [
//                        'name' => 'config.shx',
//                        'display_name' => '蜀信e配置',
//                        'route' => 'admin.config.shx',
//                        'icon_id' => '30',
//                    ],
                ]
            ],
            [
                'name' => 'user.manage',
                'display_name' => '用户管理',
                'route' => '',
                'icon_id' => '100',
                'child' => [
                    [
                        'name' => 'user.index',
                        'display_name' => '用户列表',
                        'route' => 'admin.user',
                        'icon_id' => '123',
                        'child' => [

                        ]
                    ]
                ]
            ],

        ];

        foreach ($permissions as $pem1) {
            //生成一级权限
            $p1 = \App\Entities\Permission::create([
                'name' => $pem1['name'],
                'display_name' => $pem1['display_name'],
                'route' => $pem1['route'] ?? '',
                'icon_id' => $pem1['icon_id'] ?? 1,
            ]);
            //为角色添加权限
            $role->givePermissionTo($p1);
            //为用户添加权限
            $admin->givePermissionTo($p1);
            if (isset($pem1['child'])) {
                foreach ($pem1['child'] as $pem2) {
                    //生成二级权限
                    $p2 = \App\Entities\Permission::create([
                        'name' => $pem2['name'],
                        'display_name' => $pem2['display_name'],
                        'parent_id' => $p1->id,
                        'route' => $pem2['route'] ?? 1,
                        'icon_id' => $pem2['icon_id'] ?? 1,
                    ]);
                    //为角色添加权限
                    $role->givePermissionTo($p2);
                    //为用户添加权限
                    $admin->givePermissionTo($p2);
                    if (isset($pem2['child'])) {
                        foreach ($pem2['child'] as $pem3) {
                            //生成三级权限
                            $p3 = \App\Entities\Permission::create([
                                'name' => $pem3['name'],
                                'display_name' => $pem3['display_name'],
                                'parent_id' => $p2->id,
                                'route' => $pem3['route'] ?? '',
                                'icon_id' => $pem3['icon_id'] ?? 1,
                            ]);
                            //为角色添加权限
                            $role->givePermissionTo($p3);
                            //为用户添加权限
                            $admin->givePermissionTo($p3);
                        }
                    }

                }
            }
        }

        //为用户添加角色
        $admin->assignRole($role);

        //初始化的角色
        $roles = [

        ];
        foreach ($roles as $role) {
            \App\Entities\Role::create($role);
        }
    }

}
