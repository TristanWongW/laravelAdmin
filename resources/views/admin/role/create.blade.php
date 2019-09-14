@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.role.store')}}" method="post">
                @include('admin.role._form')
            </form>
        </div>
    </div>
@endsection
@section('script')
    @include('admin.role._js')
@endsection