<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.destroy')): ?>
                    <button class="layui-btn layuiadmin-btn-admin" id="listDelete">删除</button>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.create')): ?>
                    <button class="layui-btn layuiadmin-btn-admin" id="add-btn">添加</button>
                <?php endif; ?>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.role')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="role">角色</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.permission')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="permission">权限</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.admin.destroy')): ?>
                        <a class="layui-btn layui-btn-danger layui-btn-sm " lay-event="del">删除</a>
                    <?php endif; ?>
                </div>
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        layui.use(['layer', 'table', 'form'], function () {
            var layer = layui.layer;
            var table = layui.table;
            var form = layui.form;

            var dataTable = table.render({
                elem: '#dataTable'
                , height: 'full-100'
                , url: "<?php echo e(route('admin.wechat.data')); ?>" //数据接口
                , where: {model: "admin"}
                , page: true //开启分页
                , cols: [[ //表头
                    {checkbox: true, fixed: true}
                    , {field: 'id', title: 'ID', sort: true, width: 80}
                    , {field: 'name', title: '公众号名称'}
                    , {field: 'appid', title: '昵称'}
                    , {field: 'type', title: '公众号类型'}
                    , {field: 'signing_state', title: '签约状态'}
                    , {field: 'signing_time', title: '签约时间'}
                    , {field: 'created_at', title: '创建时间'}
                    , {field: 'updated_at', title: '更新时间'}
                    , {fixed: 'right', width: 320, align: 'center', toolbar: '#options'}
                ]]
            });

            table.on('tool(dataTable)', function (obj) {
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if (layEvent === 'edit') {
                    layer.open({
                        type: 2,
                        title: '编辑管理员',
                        content: "/admin/admin/" + data.id + "/edit",
                        area: ['100%', '100%'],
                    });
                } else if (layEvent === 'role') {
                    layer.open({
                        type: 2,
                        title: '分配角色',
                        content: "/admin/admin/" + data.id + "/role",
                        area: ['100%', '100%'],
                    });
                } else if (layEvent === 'permission') {
                    layer.open({
                        type: 2,
                        title: '分配权限',
                        content: "/admin/admin/" + data.id + "/permission",
                        area: ['100%', '100%'],
                    });
                } else if (layEvent === 'del') {
                    layer.confirm('确认删除吗？', function (index) {
                        $.post("<?php echo e(route('admin.admin.destroy')); ?>", {
                            _method: 'delete',
                            ids: [data.id]
                        }, function (result) {
                            if (result.code == 0) {
                                obj.del();
                            }
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    });
                }
            });

            // 添加
            $('#add-btn').click(function () {
                layer.open({
                    type: 2,
                    title: '添加管理员',
                    content: "<?php echo e(route('admin.admin.create')); ?>",
                    area: ['100%', '100%'],
                });
            });

            // 批量删除
            $("#listDelete").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length > 0) {
                    $.each(hasCheckData, function (index, element) {
                        ids.push(element.id)
                    })
                }
                if (ids.length > 0) {
                    layer.confirm('确认删除吗？', function (index) {
                        $.post("<?php echo e(route('admin.admin.destroy')); ?>", {_method: 'delete', ids: ids}, function (result) {
                            if (result.code == 0) {
                                dataTable.reload()
                            }
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    })
                } else {
                    layer.msg('请选择删除项', {icon: 5})
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>