@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                @can('system.admin.destroy')
                <button class="layui-btn layuiadmin-btn-admin" id="listDelete">删除</button>
                @endcan
                @can('system.admin.create')
                <button class="layui-btn layuiadmin-btn-admin" id="add-btn">添加</button>
                @endcan
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('system.admin.edit')
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('system.admin.role')
                    <a class="layui-btn layui-btn-sm" lay-event="role">角色</a>
                    @endcan
                    @can('system.admin.permission')
                    <a class="layui-btn layui-btn-sm" lay-event="permission">权限</a>
                    @endcan
                    @can('system.admin.destroy')
                    <a class="layui-btn layui-btn-danger layui-btn-sm " lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'], function() {
            var layer = layui.layer;
            var table = layui.table;
            var form = layui.form;

            var dataTable = table.render({
                elem:'#dataTable'
                ,height: 'full-100'
                ,url: "{{ route('admin.admin_data') }}" //数据接口
                ,where:{model:"admin"}
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'id', title: 'ID', sort: true,width:80}
                    ,{field: 'name', title: '用户名'}
                    ,{field: 'nickname', title: '昵称'}
                    ,{field: 'email', title: '电子邮件'}
                    ,{field: 'phone', title: '手机号'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    ,{fixed: 'right', width: 320, align:'center', toolbar: '#options'}
                ]]
            });

            table.on('tool(dataTable)', function(obj) {
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if(layEvent === 'edit') {
                    layer.open({
                        type: 2,
                        title:'编辑管理员',
                        content: "/admin/admin/"+data.id+"/edit",
                        area:['100%','100%'],
                    });
                }else if(layEvent === 'role') {
                    layer.open({
                        type: 2,
                        title:'分配角色',
                        content: "/admin/admin/"+data.id+"/role",
                        area:['100%','100%'],
                    });
                }else if(layEvent === 'permission') {
                    layer.open({
                        type: 2,
                        title:'分配权限',
                        content: "/admin/admin/"+data.id+"/permission",
                        area:['100%','100%'],
                    });
                }else if(layEvent === 'del') {
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.admin.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code==0){
                                obj.del();
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    });
                }
            });

            // 添加
            $('#add-btn').click(function() {
                layer.open({
                    type: 2,
                    title:'添加管理员',
                    content: "{{route('admin.admin.create')}}",
                    area:['100%','100%'],
                });
            });

            // 批量删除
            $("#listDelete").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                if (ids.length>0){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.admin.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            });
        });
    </script>
@endsection