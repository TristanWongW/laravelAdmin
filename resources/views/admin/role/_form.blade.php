@csrf
<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input class="layui-input" type="text" name="name" lay-verify="required" value="{{$role->name??old('name')}}" placeholder="如:admin">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">显示名称</label>
    <div class="layui-input-block">
        <input class="layui-input" type="text" name="display_name" lay-verify="required" value="{{$role->display_name??old('display_name')}}" placeholder="如：管理员" >
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="*">确 认</button>
        <a href="javascript:;" class="layui-btn" onclick="closeLayerIfram(0)">返 回</a>
    </div>
</div>