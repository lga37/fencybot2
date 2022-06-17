
<?php $__env->startComponent('mail::message'); ?>

You are receiving a FencyBot Alert;<br>

The device <?php echo e($name); ?> have been close to a contamined person.<br>

Number of approximation events: <?php echo e($tot); ?><br><br>


Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/fencybot/resources/views/email/aproximation.blade.php ENDPATH**/ ?>