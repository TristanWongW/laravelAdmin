<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header  layuiadmin-card-header-auto">
            <h2>编辑用户</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="<?php echo e(route('admin.admin.update',['id'=>$admin->id])); ?>" method="post">
                <?php echo $__env->make('admin.admin._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.admin._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>