<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.permission.create')): ?>
                <button class="layui-btn layuiadmin-btn-admin add-btn" data-type="add">添加</button>
                <?php endif; ?>
                <button class="layui-btn layuiadmin-btn-admin" id="expand-collapse" status="expand">折叠/展开</button>
            </div>
            <div id="tree"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>

        // 编辑
        function edit(id) {
            layer.open({
                type: 2,
                title:'编辑权限',
                content: "/admin/permission/"+id+"/edit",
                area:['70%','500px'],
            });
        }

        // 删除
        function del(id) {
            layer.confirm('确定删除?', function() {
                $.post("<?php echo e(route('admin.permission.destroy')); ?>",{id:id,_method:'delete'},function(res){
                    if(res.code == 0) {
                        layer.msg(res.msg,{time:2000},function(){
                            $('#'+id).remove();
                        });
                    }else{
                        layer.msg(res.msg);
                    }
                },"json");
            });
        }

        var layout = [
            {name: '名称',treeNodes: true, headerClass: 'value_col', colClass: 'value_col', style: ''},
            {name: '显示名称', field: 'display_name', headerClass: 'value_col', colClass: 'value_col', style: ''},
            {name: '路由', field: 'route',headerClass: 'value_col', colClass: 'value_col', style: ''},
            {name: '图标', headerClass: 'value_col', colClass: 'value_col', style: '',render:function (row) {
                if(row.icon_id > 0 ) {
                    return '<i class="layui-icon '+row.icon.class+'"></i>';
                }else {
                    return '';
                }
            }},
            {name: '创建时间', field: 'created_at',headerClass: 'value_col', colClass: 'value_col', style: ''},
            {name: '修改时间', field: 'updated_at',headerClass: 'value_col', colClass: 'value_col', style: ''},
            {
                name: '操作', headerClass: 'value_col', colClass: 'value_col', style: 'width: 30%', render: function (row) {
                    var html = '<div class="layui-btn-group">';
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.permission.edit')): ?>
                    html += '<a class="layui-btn layui-btn-sm" onclick="edit('+row.id+')">编辑</a>';
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.permission.destroy')): ?>
                    html += '<a class="layui-btn layui-btn-danger layui-btn-sm " onclick="del('+row.id+')">删除</a>';
                    <?php endif; ?>
                    html += '</div>';
                    return html;
                }
            }
        ];

        layui.use(['form', 'myTree', 'layer'], function () {
            var layer = layui.layer, form = layui.form, $ = layui.jquery;
            var myTree = layui.myTree;

            var tree1;
            $.get("<?php echo e(route('admin.permission_data')); ?>",{},function(res){
                tree1 = myTree.treeGird({
                    elem: '#tree', //传入元素选择器
                    spreadable: true, //设置是否全展开，默认不展开
                    checkbox: false,
                    nodes: res.data,
                    layout: layout
                });
            },"json");
            form.render();
            // 添加
            $('.add-btn').click(function () {
                layer.open({
                    type: 2,
                    title:'添加权限',
                    content: "<?php echo e(route('admin.permission.create')); ?>",
                    area:['70%','500px'],
                });
            });
            // 折叠/展开
            $('#expand-collapse').click(function() {
                if($(this).attr('status') == 'collapse') {
                    $(this).attr('status', 'expand');
                    myTree.expand(tree1);
                }else{
                    $(this).attr('status', 'collapse');
                    myTree.collapse(tree1);
                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>