<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="<?php echo e(route('admin.permission.update',['id'=>$permission['id']])); ?>" method="post">
                <?php echo $__env->make('admin.permission._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.permission._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>