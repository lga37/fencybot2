<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Trackings'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php if(request()->get('d') > 0 && request()->get('m') > 0): ?>
<a class="btn btn-sm btn-outline-info" href="<?php echo e(route('alert.hist')); ?>">back</a><br><br>

<form method="POST" name="form_delAll" action="<?php echo e(route('alert.massDestroy')); ?>">

    <table class="table table-striped table-sm">

        <tr>
            <th colspan="3">
                <input type="checkbox" class="" value="1" id="checkAll" name="checkAll">
                select all
            </th>
            <th colspan="6"></th>
        </tr>

        <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><input type="checkbox" value="<?php echo e($alert->id); ?>" name="ids[]"></td>
            <td><?php echo e($alert->id); ?></td>
            <td><?php echo e($alert->device->name ?? ''); ?></td>
            <td><?php echo e($alert->fence->name ?? ''); ?></td>
            <td><?php echo e($alert->dt->format('l d/M H:i:s')); ?></td>
            <td class="">
                <a class="btn btn-sm btn-outline-info" data-lat="<?php echo e($alert->lat); ?>" data-lng="<?php echo e($alert->lng); ?>"
                    data-cerca="<?php echo e($alert->fence->fence ?? false); ?>" data-toggle="modal" data-target="#modal">detail</a>
            </td>
        </tr>

        <?php if($loop->last): ?>
        <tr>
            <td colspan="2">
                <button class="btn btn-sm btn-outline-danger">del selected</button>
            </td>
            <td colspan="7">

            </td>
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
                        href="<?php echo e(route('alert.hist',['d'=>$day->d,'m'=>$day->m,'device_id'=>$day->device_id ])); ?>"><?php echo e($day->d); ?>/<?php echo e($day->m); ?></a>
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
                        href="<?php echo e(route('alert.hist',['d'=>$day->d,'m'=>$day->m,'fence_id'=>$day->fence_id ])); ?>"><?php echo e($day->d); ?>/<?php echo e($day->m); ?></a>
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
                <div id="map_modal" class="mb-2" style="width:98%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&libraries=visualization" async
    defer></script>

<script>

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });




    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var lat, lng;

        var modal = $(this)
        modal.find('.modal-title').text('Tracking Details');
        <?php if(isset($alerts[0]) && isset($alerts[0] -> lat)): ?>

            lat = parseFloat("<?php echo e($alerts[0]->lat); ?>");
        lng = parseFloat("<?php echo e($alerts[0]->lng); ?>");

        var map_modal = new google.maps.Map(document.getElementById('map_modal'), {
            center: { lat: lat, lng: lng },
            zoom: 13,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });

        var path = [];
        var marker, contentString;
        //var infowindow = new google.maps.InfoWindow();
        <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


        lat = parseFloat("<?php echo e($alert->lat); ?>");
        lng = parseFloat("<?php echo e($alert->lng); ?>");
        marker = new google.maps.Marker({
            map: map_modal,

            <?php if($alert->type==1): ?>
                icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            <?php elseif($alert->type==2): ?>
                icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
            <?php elseif($alert->type==5): ?>
                icon: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
            <?php endif; ?>

            label: "<?php echo e($loop->iteration); ?>",
            position: { lat: lat, lng: lng }
        });


        google.maps.event.addListener(marker, "click", function () {
            //new google.maps.InfoWindow({ content: "<?php echo e($loop->iteration); ?>" }).open(map, marker);
            new google.maps.InfoWindow({ content: "<?php echo e($alert->dt->format('l d/M H:i:s')); ?>" }).open(map, marker);
        });



        path.push({ lat: parseFloat("<?php echo e($alert->lat); ?>"), lng: parseFloat("<?php echo e($alert->lng); ?>") });

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        alert('No alerts');
        <?php endif; ?>


        var pl = new google.maps.Polyline({
            path: path,
            geodesic: true,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#0000FF",
            fillOpacity: 0.1
        });
        pl.setMap(map_modal);

        <?php endif; ?>

    });



</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/hist.blade.php ENDPATH**/ ?>