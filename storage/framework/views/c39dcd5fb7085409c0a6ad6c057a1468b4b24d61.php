<?php echo e(csrf_field()); ?>

<div class="layui-form-item">
    <label for="" class="layui-form-label">用户名</label>
    <div class="layui-input-inline">
        <input type="text" name="name" value="<?php echo e($admin->name ?? old('name')); ?>" lay-verify="required" placeholder="请输入用户名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">昵称</label>
    <div class="layui-input-inline">
        <input type="text" name="nickname" value="<?php echo e($admin->nickname ?? old('nickname')); ?>" lay-verify="required" placeholder="请输入昵称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">邮箱</label>
    <div class="layui-input-inline">
        <input type="email" name="email" value="<?php echo e($admin->email??old('email')); ?>" lay-verify="email" placeholder="请输入Email" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
        <input type="text" name="phone" value="<?php echo e($admin->phone??old('phone')); ?>" required="phone" lay-verify="phone" placeholder="请输入手机号" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">密码</label>
    <div class="layui-input-inline">
        <input type="password" name="password" placeholder="请输入密码" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">确认密码</label>
    <div class="layui-input-inline">
        <input type="password" name="password_confirmation" placeholder="请输入密码" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit lay-filter="*">确 认</button>
        <a  class="layui-btn" href="javascript:;" onclick="closeLayerIfram(0)" >返 回</a>
    </div>
</div>

