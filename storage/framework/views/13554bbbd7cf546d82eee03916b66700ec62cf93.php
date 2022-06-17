<?php if(session('status')): ?>
<div class="mt-2 alert alert-info" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
<div class="mt-2 alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo e(__(Session::get('success'))); ?>

</div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
<div class="mt-2 alert alert-danger">
    <i class="fas fa-check-circle"></i> <?php echo e(Session::get('error')); ?>

</div>
<?php endif; ?>

<?php if($errors->any()): ?>

<div class="mt-2 alert alert-danger">
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>
<?php /**PATH /var/www/fencybot/resources/views/shared/msgs.blade.php ENDPATH**/ ?>