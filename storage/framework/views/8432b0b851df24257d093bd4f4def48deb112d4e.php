<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => __('Historicos/Logs')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<table class="table table-striped table-sm">
    <tr>
        <th><input type="checkbox" class="" value="1" id="checkAll" name="checkAll"><?php echo e(__('select all')); ?></th>
        <th>id</th>

        <th><?php echo e(__('column')); ?></th>
        <th><?php echo e(__('from')); ?></th>
        <th><?php echo e(__('to')); ?></th>
        <th><?php echo e(__('at')); ?></th>
        <th><?php echo e(__('map')); ?></th>


    </tr>
    <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><input type="checkbox" value="<?php echo e($history->id); ?>" name="ids[]"></td>
        <td><?php echo e($history->id); ?></td>

        <td><?php echo e($history->changed_column ?? '-'); ?></td>
        <td><?php echo e($history->changed_value_from ?? '-'); ?></td>
        <td><?php echo e($history->changed_value_to ?? '-'); ?></td>
        <td><?php echo e($history->updated_at); ?></td>
        <td class="">
            <a class="btn btn-sm btn-info"><?php echo e(__('Revert')); ?>

            </a>
        </td>
    </tr>

    <?php if($loop->last): ?>
    <tr>
        <td colspan="2">
            <button class="btn btn-sm btn-outline-danger"><?php echo e(__('del selected')); ?></button>
        </td>
        <td colspan="9"></td>
    </tr>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p><b><?php echo e(__('No records')); ?></b></p>
    <?php endif; ?>
</table>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/user/history.blade.php ENDPATH**/ ?>