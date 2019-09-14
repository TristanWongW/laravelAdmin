@extends('admin.base')

@section('content')
    <div class="layui-card">
        <form class="layui-form" action="" id="search-form">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">商户名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" placeholder="商户名称" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">交易时间</label>
                        <div class="layui-input-inline">
                            <input type="text" name="trade_time" class="layui-input" id="test1" placeholder="">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">更新时间</label>
                        <div class="layui-input-inline">
                            <input type="text" name="created_at" class="layui-input" id="test2" placeholder=" ">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-forum-list" lay-submit lay-filter="search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                @can('system.index.export')
                    <button class="layui-btn layuiadmin-btn-admin" id="import">导入</button>
                @endcan
                @can('system.index.export')
                    <a href="{{route('admin.index.export')}}" class="layui-btn layuiadmin-btn-admin" id="export">导出</a>
                @endcan
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer', 'table', 'form', 'upload', 'laydate'], function () {
            var layer = layui.layer;
            var table = layui.table;
            var form = layui.form;
            var upload = layui.upload;

            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#test1' //指定元素
            });
            laydate.render({
                elem: '#test2' //指定元素
            });
            //执行实例
            var uploadInst = upload.render({
                elem: '#import' //绑定元素
                , url: '{{route('admin.index.import')}}' //上传接口
                , accept: 'file'
                , headers: {'_token': '{{csrf_token()}}'}
                , done: function (res) {
                    //上传完毕回调
                    layer.msg(res.msg, function () {
                        window.location.href = window.location.href;
                    });
                }
                , error: function () {
                    //请求异常回调
                    layer.msg('文件错误')
                }
            });

            var dataTable = table.render({
                elem: '#dataTable'
                , height: 'full-100'
                , url: "{{ route('admin.index.data') }}" //数据接口
                , where: {model: "admin"}
                , page: true //开启分页
                , cols: [[ //表头
                    {checkbox: true, fixed: true}
                    , {field: 'id', title: 'ID', sort: true, width: 80}
                    , {field: 'name', title: '商户名称'}
                    , {field: 'trade_time', title: '交易时间'}
                    , {field: 'address', title: '商户地址'}
                    , {field: 'created_at', title: '更新时间'}
                ]]
            });

            form.on('submit(search)', function (data) {
                dataTable.reload({
                    where: data.field,
                    page: {curr: 1},
                });
                return false;
            });

        });
    </script>
@endsection



