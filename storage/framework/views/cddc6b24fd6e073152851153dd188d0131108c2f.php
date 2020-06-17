<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Alerts'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<form method="POST" action="<?php echo e(route('alert.filter')); ?>">
    <div class="input-group mb-3">

        <select class="custom-select" name="type">
            <option selected disabled>Type</option>
            <option value="1">close</option>
            <option value="2">very close</option>

        </select>
        <select class="custom-select" name="fence_id">
            <option selected disabled>Fence</option>
            <?php $__empty_1 = true; $__currentLoopData = $fences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <option value="<?php echo e($fence->id); ?>"><?php echo e($fence->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
        </select>

        <select class="custom-select" name="device_id">
            <option selected disabled>Device</option>
            <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <option value="<?php echo e($device->id); ?>"><?php echo e($device->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
        </select>


        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt1</label>
        </div>
        <input class="form-control" type="date"
        value="<?php echo e(\Carbon\Carbon::parse(now()->subDays(7))->format('Y-m-d')); ?>" id="dt1" name="dt1">

        <div class="input-group-prepend">
            <label class="input-group-text" for="dt1">dt2</label>
        </div>
        <input class="form-control" type="date"
        value="<?php echo e(\Carbon\Carbon::parse(now())->format('Y-m-d')); ?>" id="dt2" name="dt2">


        <div class="input-group-append">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Order</button>
            <div class="dropdown-menu">
                <input type="submit" value="Asc" name="order" class="dropdown-item">
                <input type="submit" value="Desc" name="order" class="dropdown-item">
                <div role="separator" class="dropdown-divider"></div>
                <input type="submit" value="Separated" name="y" class="dropdown-item">
            </div>
        </div>

    </div>
</form>

<br>


<table class="table table-striped">
    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($alert->id); ?></td>
        <td>
            <?php switch($alert->type):
            case (1): ?>
            <span class="badge badge-danger">close</span>
            <?php break; ?>

            <?php case (2): ?>
            <span class="badge badge-success">very close</span>
            <?php break; ?>


            <?php default: ?>
            <span class="badge badge-secondary">default</span>
            <?php endswitch; ?>


        </td>
        <td><?php echo e($alert->dt->format('l d/M H:i:s')); ?></td>

        <td><a class="btn btn-sm btn-info"
                onclick="javascript:geocodeLatLng('<?php echo e($alert->lat); ?>','<?php echo e($alert->lng); ?>')">local</a> </td>

        <td><?php echo e($alert->dist); ?></td>

        <td><?php echo e($alert->device->name ?? ''); ?></td>
        <td><?php echo e($alert->fence->name ?? ''); ?></td>

        <td class="">
            <button class="btn btn-primary" data-lat="<?php echo e($alert->lat); ?>" data-lng="<?php echo e($alert->lng); ?>"
                data-cerca="<?php echo e($alert->fence->fence ?? false); ?>" data-toggle="modal" data-target="#modal">map</button>
        </td>
        <td class="">
            <form method="POST" action="<?php echo e(route('alert.destroy',['alert'=>$alert])); ?>">
                <?php echo method_field('DELETE'); ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger">del</button>
            </form>
        </td>
    </tr>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p><b>No records</b></p>


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
                <div id="map" class="mb-2" style="width:98%;height:600px; "></div>
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



    function geocodeLatLng(lat, lng) {
        var geocoder = new google.maps.Geocoder;
        //console.log(geocoder);
        var latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
        //console.log(latlng);

        geocoder.geocode({ 'location': latlng }, function (results, status) {
            console.log(results);
            console.log(status);
            if (status == 'OK') {
                if (results[0]) {
                    console.log(typeof (results[0].formatted_address));
                    console.log(results[0].formatted_address);
                    alert(results[0].formatted_address);
                    //return results[0].formatted_address;
                } else {
                    return 'No results found';
                }
            } else {
                return 'Geocoder failed due to: ' + status;
            }
        });
    }






    function init() {

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var lat = parseFloat(button.data('lat')) || -22.90278;
            var lng = parseFloat(button.data('lng')) || -43.2075;
            var cerca = button.data('cerca') || false;
            var modal = $(this)
            modal.find('.modal-title').text(' Detalhamento:' + lat + ' / ' + lng)

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
            //alert(cerca);
            if (cerca) {
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
                    alert('cerca invalida');
                }
            }

        });
    }



</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/index.blade.php ENDPATH**/ ?>