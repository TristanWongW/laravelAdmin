@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable">

            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/html" id="admin_name">
        @verbatim
            {{ d.admin.name }}
        @endverbatim
    </script>
    <script>
        layui.use(['table'], function () {
            var table = layui.table;

            var dataTable = table.render({
                elem: '#dataTable'
                , height: 'full-100'
                , url: "{{ route('admin.operation_log.data') }}" //数据接口
                , where: {model: "admin"}
                , page: true //开启分页
                , cols: [[ //表头
                    {checkbox: true, fixed: true}
                    , {field: 'id', title: 'ID', sort: true, width: 80}
                    , {field: 'admin_id', title: '用户名', templet: '#admin_name'}
                    , {field: 'path', title: '路径'}
                    , {field: 'method', title: '方法'}
                    , {field: 'ip', title: 'ip地址'}
                    , {field: 'input', title: '内容'}
                    , {field: 'created_at', title: '创建时间'}
                    , {field: 'updated_at', title: '更新时间'}
                    , {fixed: 'right', width: 320, align: 'center', toolbar: '#options'}
                ]]
            });
        });
    </script>
@endsection