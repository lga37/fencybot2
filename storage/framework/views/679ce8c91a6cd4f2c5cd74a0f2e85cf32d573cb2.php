
<?php $__env->startComponent('mail::message'); ?>

You are receiving a FencyBot Alert;

<ul>
    <li>Lat: <?php echo e($alert->lat); ?></li>
    <li>Lng: <?php echo e($alert->lng); ?></li>
    <li>Time: <?php echo e($alert->dt); ?></li>

</ul>




Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/fencybot/resources/views/email/alert.blade.php ENDPATH**/ ?>