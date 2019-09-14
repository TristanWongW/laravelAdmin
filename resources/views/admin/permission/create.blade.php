@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.permission.store')}}" method="post">
                @include('admin.permission._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.permission._js')
@endsection