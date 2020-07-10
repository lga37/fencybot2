<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Alerts'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php if(request()->get('d') > 0 && request()->get('m') > 0): ?>
<a class="btn btn-sm btn-outline-info" href="<?php echo e(route('alert.index')); ?>">back</a><br><br>

<form method="POST" name="form_delAll" action="<?php echo e(route('alert.massDestroy')); ?>">
    <?php echo csrf_field(); ?>
    <table class="table table-striped table-sm">
        <tr>
            <th><input type="checkbox" class="" value="1" id="checkAll" name="checkAll"> select all</th>
            <th>id</th>
            <th>type</th>
            <th>fence</th>
            <th>device</th>
            <th>time</th>
            <th>dist</th>
            <th>map</th>
        </tr>


        <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <tr>
            <td><input type="checkbox" value="<?php echo e($alert->id); ?>" name="ids[]"></td>
            <td><?php echo e($alert->id); ?></td>
            <td>
                <?php switch($alert->type):
                case (0): ?>
                <span class="badge badge-secondary">default/inside</span>
                <?php break; ?>
                <?php case (1): ?>
                <span class="badge badge-danger">close</span>
                <?php break; ?>
                <?php case (2): ?>
                <span class="badge badge-success">out of fence</span>
                <?php break; ?>
                <?php case (3): ?>
                <span class="badge badge-info">invasion</span>
                <?php break; ?>
                <?php case (4): ?>
                <span class="badge badge-warning">off</span>
                <?php break; ?>
                <?php case (5): ?>
                <span class="badge badge-primary">back</span>
                <?php break; ?>
                <?php default: ?>
                <span class="badge badge-secondary">default</span>
                <?php endswitch; ?>
            </td>
            <td><?php echo e($alert->fence->name ?? '-'); ?></td>
            <td><?php echo e($alert->device->name ?? '-'); ?></td>
            <td><?php echo e($alert->dt->format('l d/M H:i:s')); ?></td>
            <td><?php echo e($alert->dist ?? '-'); ?></td>
            <td class="">
                <a class="btn btn-sm btn-info" data-lat="<?php echo e($alert->lat); ?>" data-lng="<?php echo e($alert->lng); ?>"
                    data-cerca="<?php echo e($alert->fence->fence ?? false); ?>" data-toggle="modal" data-target="#modal">map
                </a>
            </td>
        </tr>

        <?php if($loop->last): ?>
        <tr>
            <td colspan="2">
                <button class="btn btn-sm btn-outline-danger">del selected</button>
            </td>
            <td colspan="9"></td>
        </tr>
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p><b>No records</b></p>
        <?php endif; ?>
    </table>

</form>

<?php else: ?>


<div class="row">
    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => 'Grouped By Device'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th>device</th>
            </tr>
            <?php $__empty_1 = true; $__currentLoopData = $device_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($day->tot); ?></td>
                <td><a
                        href="<?php echo e(route('alert.index',['d'=>$day->d,'m'=>$day->m,'device_id'=>$day->device_id ])); ?>"><?php echo e($day->d); ?>/<?php echo e($day->m); ?></a>
                </td>
                <td><?php echo e($day->device->name); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p><b>No records</b></p>
            <?php endif; ?>
        </table>

    </div>
    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => 'Grouped By Fence'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th>fence</th>
            </tr>
            <?php $__empty_1 = true; $__currentLoopData = $fence_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($day->tot); ?></td>
                <td><a
                        href="<?php echo e(route('alert.index',['d'=>$day->d,'m'=>$day->m,'fence_id'=>$day->fence_id ])); ?>"><?php echo e($day->d); ?>/<?php echo e($day->m); ?></a>
                </td>
                <td><?php echo e($day->fence->name); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p><b>No records</b></p>
            <?php endif; ?>
        </table>

    </div>
</div>


<?php endif; ?>










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


    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });




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
            modal.find('.modal-title').text(' Details:' + lat + ' / ' + lng)

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
our met

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/index.blade.php ENDPATH**/ ?>