<?php

Route::group(['namespace' => 'Admin'], function ($router) {
    $router->get('/login', 'LoginController@showLoginForm')->name('admin.LoginForm');
    $router->post('login', 'LoginController@login')->name('admin.login');
    $router->get('logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth:admin', 'operation.log']], function ($router) {
    // 系统管理
    Route::group(['middleware' => ['permission:system.manage']], function ($router) {
        $router->get('/', 'IndexController@layout')->name('admin.layout');
        $router->get('/index', 'IndexController@index')->name('admin.index');
        $router->get('/index2', 'IndexController@index2')->name('admin.index2');
        $router->get('/index3', 'IndexController@index3')->name('admin.index3');
        $router->get('/icons', 'IndexController@icons')->name('admin.icons');
        $router->get('/admin/password', 'AdminController@password')->name('admin.admin.password');
        $router->put('/admin/resetPassword', 'AdminController@resetPassword')->name('admin.admin.resetPassword');

        // 文件上传
        $router->any('/uploadImage', 'UploadController@uploadImage')->name('admin.uploadImage');
        $router->any('/uploadFile', 'UploadController@uploadFile')->name('admin.uploadFile');

        // 更改排序字段
        $router->any('/updateSort', 'CommonController@updateSort')->name('admin.updateSort');
        $router->any('/changeTableVal', 'CommonController@changeTableVal')->name('admin.changeTableVal');

        // 管理员管理
        Route::group(['middleware' => ['permission:system.admin']], function ($router) {
            $router->get('/admin', 'AdminController@index')->name('admin.admin');
            $router->get('/admin/data', 'AdminController@data')->name('admin.admin_data');
            $router->get('/admin/create', 'AdminController@create')->name('admin.admin.create')->middleware('permission:system.admin.create');
            $router->post('/admin/store', 'AdminController@store')->name('admin.admin.store')->middleware('permission:system.admin.create');
            $router->get('/admin/{id}/edit', 'AdminController@edit')->name('admin.admin.edit')->middleware('permission:system.admin.edit');
            $router->post('/admin/{id}/update', 'AdminController@update')->name('admin.admin.update')->middleware('permission:system.admin.edit');
            $router->delete('/admin/delete', 'AdminController@destroy')->name('admin.admin.destroy')->middleware('permission:system.admin.destroy');
            $router->get('/admin/{id}/role', 'AdminController@role')->name('admin.admin.role')->middleware('permission:system.admin.role');
            $router->put('/admin/{id}/assignRole', 'AdminController@assignRole')->name('admin.admin.assignRole')->middleware('permission:system.admin.role');
            $router->get('/admin/{id}/permission', 'AdminController@permission')->name('admin.admin.permission')->middleware('permission:system.admin.permission');
            $router->put('/admin/{id}/assignPermission', 'AdminController@assignPermission')->name('admin.admin.assignPermission')->middleware('permission:system.admin.permission');
        });

        // 角色管理
        Route::group(['middleware' => ['permission:system.role']], function ($router) {
            $router->get('/role', 'RoleController@index')->name('admin.role');
            $router->get('/role/data', 'RoleController@data')->name('admin.role_data');
            $router->get('/role/create', 'RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
            $router->post('/role/store', 'RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
            $router->get('/role/{id}/edit', 'RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
            $router->post('/role/{id}/update', 'RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
            $router->get('/role/{id}/permission', 'RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
            $router->put('role/{id}/assignPermission', 'RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
            $router->delete('/role/delete', 'RoleController@destroy')->name('admin.role.destroy');
        });

        // 权限管理
        Route::group(['middleware' => ['permission:system.permission']], function ($router) {
            $router->get('/permission', 'PermissionController@index')->name('admin.permission');
            $router->get('/permission/data', 'PermissionController@data')->name('admin.permission_data');
            $router->get('/permission/create', 'PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
            $router->post('/permission/store', 'PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
            $router->get('/permission/{id}/edit', 'PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
            $router->post('/permission/{id}/update', 'PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
            $router->delete('/permission/delete', 'PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
        });

        // 后台登录日志
        $router->get('/admin_log', 'AdminLogController@index')->name('admin.admin_log')->middleware('permission:system.admin_log');
        $router->get('/admin_log/data', 'AdminLogController@data')->name('admin.admin_log.data')->middleware('permission:system.admin_log');

        // 后台操作日志
        $router->get('/operation_log', 'OperationLogController@index')->name('admin.operation_log')->middleware('permission:system.admin_operation_log');
        $router->get('/operation_log/data', 'OperationLogController@data')->name('admin.operation_log.data')->middleware('permission:system.admin_operation_log');
    });
    // 基本配置
    Route::group(['middleware' => ['permission:config.manage']], function ($router) {
        $router->get('/config/site', 'ConfigController@site')->name('admin.config.site')->middleware('permission:config.site');
        $router->put('/config/siteUpdate', 'ConfigController@siteUpdate')->name('admin.config.siteUpdate')->middleware('permission:config.site');
        $router->get('/config/wx', 'ConfigController@wx')->name('admin.config.wx')->middleware('permission:config.wx');
        $router->put('/config/wxUpdate', 'ConfigController@wxUpdate')->name('admin.config.wxUpdate')->middleware('permission:config.wx');
        $router->get('/config/shx', 'ConfigController@shx')->name('admin.config.shx')->middleware('permission:config.shx');
        $router->put('/config/shxUpdate', 'ConfigController@shxUpdate')->name('admin.config.shxUpdate')->middleware('permission:config.shx');
    });

    Route::group(['middleware' => ['permission:wechat.data']], function ($router) {
        $router->get('/wechat/index', 'WechatController@index')->name('admin.wechat.index')->middleware('permission:wechat.index');
        $router->get('/wechat/data', 'WechatController@data')->name('admin.wechat.data')->middleware('permission:wechat.index');

    });
    Route::group(['middleware' => ['permission:user.index']], function ($router) {
        $router->get('/user/index', 'WechatController@index')->name('admin.user')->middleware('permission:user.index');
    });

});

