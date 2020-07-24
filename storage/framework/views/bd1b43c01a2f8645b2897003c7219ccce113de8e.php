<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => __('Invasions')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<table class="table table-striped table-sm">
    <tr>
        <th>id</th>
        <th><?php echo e(__('device')); ?></th>
        <th><?php echo e(__('time')); ?></th>
        <th><?php echo e(__('phone')); ?></th>
        <th><?php echo e(__('map')); ?></th>
        <th><?php echo e(__('del')); ?></th>

    </tr>
    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


    <tr>
        <td><?php echo e($alert->id); ?></td>


            <td><?php echo e($alert->device->name ?? ''); ?></td>
            <td><?php echo e($alert->dt->format('l d/M H:i:s')); ?></td>

            <td><?php echo e($alert->phone ?? '-'); ?></td>

        <td class="">
            <button class="btn btn-sm btn-primary" data-lat="<?php echo e($alert->lat); ?>" data-lng="<?php echo e($alert->lng); ?>"
                data-cerca="<?php echo e($alert->fence->fence ?? false); ?>"
                data-toggle="modal" data-target="#modal"><?php echo e(__('map')); ?></button>
        </td>
        <td class="">
            <form method="POST" action="<?php echo e(route('alert.destroy',['alert'=>$alert])); ?>">
                <?php echo method_field('DELETE'); ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm btn-danger"><?php echo e(__('del')); ?></button>
            </form>
        </td>
    </tr>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p><b><?php echo e(__('No records')); ?></b></p>


    <?php endif; ?>
</table>


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map" class="mb-2" style="width:98%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close*')); ?></button>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&libraries=visualization"
    async defer></script>

<script>

    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var lat = parseFloat(button.data('lat')) || -22.90278;
        var lng = parseFloat(button.data('lng')) || -43.2075;
        //var cerca = button.data('cerca') || false;
        var modal = $(this)
        modal.find('.modal-title').text("<?php echo e(__('Tracking Details')); ?>" + lat + ' / ' + lng)

        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: lat, lng: lng },
            zoom: 15,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false

        });
        const marker = new google.maps.Marker({
            map: map,
            position: { lat: lat, lng: lng }
        });

    });




</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/invasions.blade.php ENDPATH**/ ?>