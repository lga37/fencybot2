<?php $__env->startSection('content'); ?>


<?php if(session('status')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<h1>Editar cerca # <?php echo e($fence->id); ?> (<?php echo e($fence->name); ?>) </h1>
<?php echo e($fence); ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mapa', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cerca/resources/views/fence/edit.blade.php ENDPATH**/ ?>