@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header  layuiadmin-card-header-auto">
            <h2>编辑用户</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.admin.update',['id'=>$admin->id])}}" method="post">
                @include('admin.admin._form')
            </form>
        </div>
    </div>
@endsection
@section('script')
    @include('admin.admin._js')
@endsection