<?php $__env->startSection('content'); ?>

<?php if(session('status')): ?>
<div class="track track-success" role="track">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>


<h1>Trackings </h1>
<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>ts</th>
        <th>cerca</th>
        <th>device</th>
        <th>type</th>
        <th>lat/lng</th>
        <th>dist</th>
        <th>dt</th>
        <th>map</th>
        <th>del</th>
    </tr>


    <?php $__empty_1 = true; $__currentLoopData = $tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <tr>
        <td><?php echo e($track->id); ?></td>
        <td><?php echo e($track->created_at); ?></td>
        <td><?php echo e($track->device->name ?? ''); ?></td>
        <td><?php echo e($track->fence->name ?? ''); ?></td>
        <td><span class="badge badge-warning">tocou</span></td>
        <td><?php echo e($track->lat); ?> <?php echo e($track->lng); ?> </td>
        <td><?php echo e($track->dist); ?></td>
        <td><?php echo e($track->dt); ?></td>

        <td class="px-4 py-4">
            <button class="btn btn-primary"
            data-cerca="<?php echo e($track->fence->name); ?>" data-lat="<?php echo e($track->lat); ?>"
                data-lng="<?php echo e($track->lng); ?>" data-toggle="modal" data-target="#modal">map</button>
        </td>


        <td class="px-4 py-4">
            <form method="POST" action="<?php echo e(route('track.destroy',['track'=>$track])); ?>">
                <?php echo method_field('DELETE'); ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger">del</button>
            </form>
        </td>
    </tr>

    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


    <?php endif; ?>
</table>

<hr>

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
                <div id="map" class="mb-2" style="width:700px;height:600px; ">
                    <!--                     <div style="width: 100%; height: 100%" id="address-map"></div>
 -->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&callback=init" async defer></script>
<script>

    function init() {

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var lat = parseFloat(button.data('lat'));
            var lng = parseFloat(button.data('lng'));
            var cerca = button.data('cerca');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            //modal.find('.modal-title').text('New message to ' + recipient)
            //modal.find('.modal-body input').val(recipient)

            lat = -22.90278;
            lng = -43.2075;

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

            var fence = new GMapFence();
            for (let i = 0; i < cerca.length; i++) {
                fence.addVertex(cerca[i]);
            }

            if (fence.isValid()) {


                /*                 var bounds = new google.maps.LatLngBounds(
                                    marker1.getPosition(), marker2.getPosition()
                                    fence.getBounds()
                                );
                                map.fitBounds(bounds); */

                var pl = new google.maps.Polygon({
                    path: fence.generatePath(),
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#0000FF",
                    fillOpacity: 0.1
                });

                pl.setMap(map);

            } else {
                track('cerca invalida');
            }

        });




    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cerca/resources/views/track/index.blade.php ENDPATH**/ ?>