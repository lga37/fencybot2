<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => __('Trackings') ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php if(request()->get('d') > 0 && request()->get('m') > 0): ?>
<a class="btn btn-sm btn-outline-info" href="<?php echo e(route('alert.hist')); ?>"><?php echo e(__('back')); ?></a><br><br>

<div id="map" class="mb-2" style="width:98%;height:600px;"></div>



<?php $__empty_1 = true; $__currentLoopData = $fences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if(isset($fence->name)): ?>
        <span class="tem_cerca" data-cercanome="<?php echo e($fence->name); ?>" data-cerca="<?php echo e($fence->fence); ?>"></span>

    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>


<form method="POST" name="form_delAll" action="<?php echo e(route('alert.massDestroy')); ?>">

    <table class="table table-striped table-sm">

        <tr>
            <th colspan="3">
                <input type="checkbox" class="" value="1" id="checkAll" name="checkAll">
                <?php echo e(__('select all')); ?>

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
                    data-cerca="<?php echo e($alert->fence->fence ?? false); ?>"
                    data-nome_cerca="<?php echo e($alert->fence->name ?? false); ?>"
                    data-toggle="modal" data-target="#modal"><?php echo e(__('detail')); ?></a>
            </td>
        </tr>

        <?php if($loop->last): ?>
        <tr>
            <td colspan="2">
                <button class="btn btn-sm btn-outline-danger"><?php echo e(__('del selected')); ?></button>
            </td>
            <td colspan="7">

            </td>
        </tr>
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p><b><?php echo e(__('No records')); ?></b></p>
        <?php endif; ?>
    </table>
</form>

<?php else: ?>
<div class="row">
    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => __('Grouped By Device') ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th><?php echo e(__('device')); ?></th>
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
            <p><b><?php echo e(__('No records')); ?></b></p>
            <?php endif; ?>
        </table>

    </div>
    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => __('Grouped By Fence') ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <table class="table table-striped table-sm">
            <tr>
                <th>Total</th>
                <th>dd/mm</th>
                <th><?php echo e(__('fence')); ?></th>
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
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <?php echo e(__('Close*')); ?></button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

<script>

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });




    function show() {
        var lat, lng;
        <?php if(isset($alerts[0]) && isset($alerts[0] -> lat)): ?>

            lat = parseFloat(<?php echo e($alerts[0]-> lat); ?>) || -22.90278;
    lng = parseFloat(<?php echo e($alerts[0]-> lng); ?>) || -43.2075;


    var map_modal = new google.maps.Map(document.getElementById('map'), {
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
    <?php $pula = false; ?>
    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


    lat = parseFloat("<?php echo e($alert->lat); ?>");
    lng = parseFloat("<?php echo e($alert->lng); ?>");
    marker = new google.maps.Marker({
        map: map_modal,

                <?php if($alert -> type == 0): ?>
        icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
                <?php elseif($alert -> type == 1): ?>
    icon: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
                <?php elseif($alert -> type == 2): ?>
    icon: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                <?php elseif($alert -> type == 5): ?>
    icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                <?php endif; ?>

    label: "<?php echo e($loop->iteration); ?>",
        position: { lat: lat, lng: lng }
            });


    google.maps.event.addListener(marker, "click", function () {
        //new google.maps.InfoWindow({ content: "<?php echo e($loop->iteration); ?>" }).open(map, marker);
        new google.maps.InfoWindow({ content: "<?php echo e($alert->dt->format('l d/M H:i:s')); ?>" }).open(map, marker);
    });


    <?php if($pula == false): ?>
        path.push({ lat: parseFloat("<?php echo e($alert->lat); ?>"), lng: parseFloat("<?php echo e($alert->lng); ?>") });

    <?php endif; ?>


    <?php if($alert -> type == 5): ?>
        <?php $pula = true; ?>
    <?php else: ?>
    <?php $pula = false; ?>
    <?php endif; ?>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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


    $('.tem_cerca').each(function (v) {
        //console.log(v);
        //console.log($(this).data('cerca'));
        //alert($(this).data('cerca').value);

        var coords = $(this).data('cerca');


        var cerca = new google.maps.Polygon({
            path: coords,
            strokeColor: "#000000",
            strokeOpacity: 0.9,
            strokeWeight: 2,
            fillColor: "#000000",
            fillOpacity: 0.3
        });

        cerca.setMap(map_modal);


    });




    <?php endif; ?>

    }










    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var modal = $(this)
        modal.find('.modal-title').text("<?php echo e(__('Tracking Details')); ?>");

        var lat = parseFloat(button.data('lat')) || -22.90278;
        var lng = parseFloat(button.data('lng')) || -43.2075;
        var cerca = button.data('cerca') || false;
        var nome_cerca = button.data('nome_cerca') || false;



        var map_modal = new google.maps.Map(document.getElementById('map_modal'), {
            center: { lat: lat, lng: lng },
            zoom: 13,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });

        const marker = new google.maps.Marker({
            map: map_modal,
            position: { lat: lat, lng: lng }
        });


        if (cerca) {

            //alert(cerca);

            var div = document.createElement('div');
            var h3 = document.createElement('h3');

            h3.innerHTML = ' ' + nome_cerca + ' ';
            div.appendChild(h3);

            map_modal.controls[google.maps.ControlPosition.RIGHT_TOP].push(div);



            var fence = new GMapFence();
            for (let i = 0; i < cerca.length; i++) {
                fence.addVertex(cerca[i]);
            }

            console.log(fence.generatePath());

            if (fence.isValid()) {
                var pl = new google.maps.Polygon({
                    path: fence.generatePath(),
                    //path: fence.generatePath(),
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.9,
                    strokeWeight: 3,
                    fillColor: "#0000FF",
                    fillOpacity: 0.3
                });
                pl.setMap(map_modal);

            } else {
                alert('cerca invalida');
            }



            $('.tem_cerca').each(function (v) {
                var coords = $(this).data('cerca');
                var cerca = new google.maps.Polygon({
                    path: coords,
                    strokeColor: "#000000",
                    strokeOpacity: 0.9,
                    strokeWeight: 2,
                    fillColor: "#000000",
                    fillOpacity: 0.3
                });

                cerca.setMap(map_modal);

            });

        }


        });






</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>&callback=show"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/alert/hist.blade.php ENDPATH**/ ?>