
<?php $__env->startComponent('mail::message'); ?>

You are receiving a FencyBot Alert;

<ul>
    <li>Time: <?php echo e($alert->dt); ?></li>
    <li>Device: <?php echo e($alert->device->name); ?></li>
    <li>Fence: <?php echo e($alert->fence->name); ?></li>
    <li>Link on Map: <a href="http://www.google.com/maps/place/<?php echo e($alert->lat); ?>,<?php echo e($alert->lng); ?>">Check</a></li>
    <li>Lat: <?php echo e($alert->lat); ?></li>
    <li>Lng: <?php echo e($alert->lng); ?></li>

</ul>




Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/fencybot/resources/views/email/alert.blade.php ENDPATH**/ ?>