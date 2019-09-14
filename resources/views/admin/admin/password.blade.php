@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header  layuiadmin-card-header-auto">
            <h2>修改密码</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.admin.resetPassword')}}" method="post">
                @csrf
                {{method_field('put')}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">原始密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password_old" lay-verify="required" placeholder="请输入原始密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" lay-verify="required" placeholder="请输入密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password_confirmation" lay-verify="required" placeholder="请输入密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit lay-filter="*">确 认</button>
                        {{--<a  class="layui-btn" href="javascript:;" onclick="closeLayerIfram(0)" >返 回</a>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['form'], function () {
            var form = layui.form;
            var post_url = $('.layui-form').attr('action');
            form.on('submit(*)', function (data) {
                $.post(post_url, data.field, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {time: 1500}, function () {
                            parent.location.replace("{{route('admin.admin')}}");
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
                return false;
            });
        });
    </script>
@endsection