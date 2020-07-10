<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Types'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<a href="<?php echo e(route('alert.parse',['device_id'=>$device->id ])); ?>">parse <?php echo e($device->name); ?></a> <br>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
sem regs
<?php endif; ?>


<?php echo e($types); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&libraries=places" async defer></script>


<script>


    /*
    The "status" field within the search response object contains the status of the request, and may contain debugging information to help you track down why the request failed. The "status" field may contain the following values:
    OK indicates that no errors occurred; the place was successfully detected and at least one result was returned.
    ZERO_RESULTS indicates that the search was successful but returned no results. This may occur if the search was passed a latlng in a remote location.
    OVER_QUERY_LIMIT indicates that you are over your quota.
    REQUEST_DENIED indicates that your request was denied, generally because of lack of an invalid key parameter.
    INVALID_REQUEST generally indicates that a required query parameter (location or radius) is missing.
    UNKNOWN_ERROR
    */

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/type/index.blade.php ENDPATH**/ ?>