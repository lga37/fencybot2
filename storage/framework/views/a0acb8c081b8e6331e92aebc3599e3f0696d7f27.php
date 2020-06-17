<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Devices'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<form method="POST" action="<?php echo e(route('device.store')); ?>">
    <?php echo csrf_field(); ?>

    <div class="input-group mt-1">
        <div class="input-group-prepend">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                title="Name of this device"><span data-feather="target"></span></div>
        </div>
        <input class="form-control" placeholder="Device Name" name="name" >
    </div>

    <div class="input-group mt-1">
        <div class="input-group-prepend">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                title="Phone number of this device"><span data-feather="phone"></span></div>
        </div>
        <input class="form-control" placeholder="Device Tel Number" name="tel" >
    </div>

    <br>

    <div class="row">
        <div class="col-md-1">
            <div class="" data-toggle="tooltip" data-placement="top"
            title="Time to receive the alert in seconds, from 0 to 60">? time</div>
        </div>
        <div class="col-md-9">
            <input type="range" name="t" id="t" class="custom-range"
                min="0" step="5" max="60" oninput="t_output.value = t.value">
        </div>
        <div class="col-md-1">
            <output name="t_output" id="t_output"></output>
        </div>
    </div>


    <div class="row">
        <div class="col-md-1">
            <div class="" data-toggle="tooltip" data-placement="top"
            title="Minimal distance to Associated Fence, from 10 to 50 meters ">? dist</div>
        </div>
        <div class="col-md-9">
            <input type="range" name="d" id="d" class="custom-range"
                min="10" step="5" max="50" oninput="d_output.value = d.value">
        </div>
        <div class="col-md-1">
            <output name="d_output" id="d_output"></output>
        </div>
    </div>


    <div class="row">
        <div class="col-md-1">
            <div class="" data-toggle="tooltip" data-placement="top"
            title="Radius of the Personal Area, from 1 to 5 meters,
            used to fire a meet event with others registered Users">? radius</div>
        </div>
        <div class="col-md-9">
            <input type="range" name="r" id="r" class="custom-range"
                min="1" step=".5" max="5" oninput="r_output.value = r.value">
        </div>
        <div class="col-md-1">
            <output name="r_output" id="r_output"></output>
        </div>
    </div>

    <br>

    <div class="input-group mt-1">
        <div class="input-group-prepend">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                title="Associated Fences for this Device">?</div>
        </div>
        <select
        title="Fences Associated to this Device"

        name="fences_id[]" class="form-control border border-info selectpicker"
        multiple>
            <?php
            foreach ($fences as $fence):
                echo sprintf("<option value='%d'>%s</option>",$fence->id,$fence->name);
            endforeach;
            ?>
        </select>
        </div>

    <button class="btn mt-2 btn-lg btn-success">create</button>
</form>
<br>


<?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<?php if($loop->first): ?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <?php endif; ?>
        <div class="col-auto mb-3">
            <div class="card p-0" style="width: 20rem;">
                <div class="card-body p-2">
                    <form method="POST" action="<?php echo e(route('device.update',['device'=>$device->id])); ?>">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>

                        <div class="input-group mt-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                                title="Name of this device"><span data-feather="target"></span></div>
                            </div>
                            <input class="form-control" name="name" value="<?php echo e($device->name); ?>">
                        </div>

                        <div class="input-group mt-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                                title="Phone number of this device"><span data-feather="phone"></span></div>
                            </div>
                            <input class="form-control" name="tel" value="<?php echo e($device->tel); ?>">
                        </div>



                        <br>

                        <div class="row">
                            <div class="col-md-1">
                                <div class="" data-toggle="tooltip" data-placement="top"
                                title="Time to receive the alert in seconds, from 0 to 60">?</div>
                            </div>
                            <div class="col-md-9">
                                <input type="range" name="t" id="t" class="custom-range" value=" <?php echo e($device->t); ?>"
                                min="0" step="5" max="60" oninput="t_output.value = t.value">
                            </div>
                            <div class="col-md-1">
                                <output name="t_output" id="t_output"><?php echo e($device->t); ?></output>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-1">
                                <div class="" data-toggle="tooltip" data-placement="top"
                                title="Minimal distance to Associated Fence, from 10 to 50 meters ">?</div>
                            </div>
                            <div class="col-md-9">
                                <input type="range" name="d" id="d" class="custom-range" value=" <?php echo e($device->d); ?>"
                                min="10" step="5" max="50" oninput="d_output.value = d.value">
                            </div>
                            <div class="col-md-1">
                                <output name="d_output" id="d_output"><?php echo e($device->d); ?></output>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-1">
                                <div class="" data-toggle="tooltip" data-placement="top"
                                title="Radius of the Personal Area, from 1 to 5 meters,
            used to fire a meet event with others registered Users">?</div>
                            </div>
                            <div class="col-md-9">
                                <input type="range" name="r" id="r" class="custom-range" value=" <?php echo e($device->r); ?>"
                                min="1" step=".5" max="5" oninput="r_output.value = r.value">
                            </div>
                            <div class="col-md-1">
                                <output name="r_output" id="r_output"><?php echo e($device->r); ?></output>
                            </div>
                        </div>

                        <br>

                        <select
                        title="Fences Associated to this Device"
                        name="fences_id[]"
                        class="form-control border border-info selectpicker" multiple>
                            <?php
                            foreach ($fences as $fence):
                                $sel = '';
                                if(isset($device->fences)){
                                    $sel = in_array($fence->id,$device->fences->pluck('id')->toArray())? 'selected':'';
                                }
                                echo sprintf("<option %s value='%d'>%s</option>",$sel,$fence->id,$fence->name);
                            endforeach;
                            ?>
                        </select>
                        <button class="btn mt-2 btn-sm btn-success">save</button>
                    </form>

                </div>
                <div class="card-footer">

                    <form method="POST" action="<?php echo e(route('device.destroy',['device'=>$device])); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>

                        <?php if(count($device->fences)>0): ?>
                        <a href="#" class="mr-2 btn btn-sm btn-primary" data-cercas="<?php echo e($device->fences ?? false); ?>"
                            data-name="<?php echo e($device->name); ?>" data-toggle="modal" data-target="#device_modal">
                            map
                        </a>
                        <?php endif; ?>

                        <button class="btn btn-sm btn-danger">del</button>

                    </form>


                </div>
            </div>
        </div>


        <?php if($loop->last): ?>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<p><b>No records</b></p>
<?php endif; ?>


<div class="modal fade" id="device_modal" tabindex="-1" role="dialog" aria-labelledby="device_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_cerca">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_cerca" class="mb-2" style="width:99%;height:600px; "></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>" async
    defer></script>
<script>

    $('#device_modal').on('show.bs.modal', function (event) {

        var bounds = new google.maps.LatLngBounds();
        var i;

        // The Bermuda Triangle
        var polygonCoords = [
            new google.maps.LatLng(25.774252, -80.190262),
            new google.maps.LatLng(18.466465, -66.118292),
            new google.maps.LatLng(32.321384, -64.757370),
            new google.maps.LatLng(25.774252, -80.190262)
        ];

        for (i = 0; i < polygonCoords.length; i++) {
            bounds.extend(polygonCoords[i]);
        }

        // The Center of the Bermuda Triangle - (25.3939245, -72.473816)
        console.log(bounds.getCenter());

        //event.preventDefault();
        //alert(11)
        var button = $(event.relatedTarget)
        //var lat = parseFloat(button.data('lat'));
        //var lng = parseFloat(button.data('lng'));
        var cercas = button.data('cercas');
        var label_cerca = button.data('name');
        $("#label_cerca").text(label_cerca);


        console.log(cercas);

        var fence = new GMapFence();
        for (let i = 0; i < cercas[0].length; i++) {
            //var utm = GeoConverson.LatLng2UTM(cerca[i].lat, cerca[i].lng);
            //console.log(utm);
            //fence.addVertex(new GeoPoint(parseFloat(cerca[i].lat), parseFloat(cerca[i].lng)));
            //fence.addVertex(cerca[i]);
        }

        //lat = -22.90278;
        //lng = -43.2075;
        var centralPoint = fence.centralPointLatLng();
        console.log(centralPoint);
        var map = new google.maps.Map(document.getElementById('map_cerca'), {
            center: bounds.getCenter(),
            //center: { lat: lat, lng: lng },
            zoom: 15,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });



        var pl = new google.maps.Polygon({
            path: polygonCoords,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#0000FF",
            fillOpacity: 0.1
        });

        pl.setMap(map);


    });


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/device/index.blade.php ENDPATH**/ ?>