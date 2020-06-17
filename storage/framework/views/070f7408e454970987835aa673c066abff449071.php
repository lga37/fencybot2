<?php if(session('status')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo e(Session::get('success')); ?>

</div>
<?php endif; ?>

<?php if(Session::has('errors')): ?>
<div class="alert alert-danger">
    <i class="fas fa-check-circle"></i> <?php echo e(Session::get('errors')); ?>

</div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
<div class="alert alert-danger">
    <i class="fas fa-check-circle"></i> <?php echo e(Session::get('error')); ?>

</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class=”alert alert-danger”>
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<?php /**PATH /var/www/fencybot/resources/views/shared/msgs.blade.php ENDPATH**/ ?>