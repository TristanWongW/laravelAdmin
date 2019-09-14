<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable">

            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/html" id="admin_name">
        
            {{ d.admin.name }}
        
    </script>
    <script>
        layui.use(['table'], function () {
            var table = layui.table;

            var dataTable = table.render({
                elem: '#dataTable'
                , height: 'full-100'
                , url: "<?php echo e(route('admin.admin_log.data')); ?>" //数据接口
                , where: {model: "admin"}
                , page: true //开启分页
                , cols: [[ //表头
                    {checkbox: true, fixed: true}
                    , {field: 'id', title: 'ID', sort: true, width: 80}
                    , {field: 'admin_id', title: '用户名', templet: '#admin_name'}
                    , {field: 'ip', title: 'ip地址'}
                    , {field: 'created_at', title: '创建时间'}
                    , {field: 'updated_at', title: '更新时间'}
                    , {fixed: 'right', width: 320, align: 'center', toolbar: '#options'}
                ]]
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>