<?php $__env->startSection('css'); ?>
<style>
    .vitrine:hover {
        border: 1px solid blue;
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<form method="POST" action="<?php echo e(route('device.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="input-group mt-1">
        <div class="input-group-prepend">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top" title="Name of this device">Add New
                Device</div>
        </div>
        <div class="input-group-prepend ml-1">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top" title="Name of this device"><span
                    data-feather="target"></span></div>
        </div>
        <input class="form-control" placeholder="Device Name" name="name">


        <div class="input-group-prepend ml-1">
            <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                title="Phone number of this device"><span data-feather="phone"></span></div>
        </div>
        <input class="form-control" placeholder="Device Tel Number" name="tel">

        <button class="ml-1 btn btn-outline-success">Add</button>
    </div>


</form>


<!-- <div class="card border-success mb-3">
    <div class="card-header">Add New Device</div>
    <div class="card-body text-success">


        <form method="POST" action="<?php echo e(route('device.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="input-group mt-1">
                <div class="input-group-prepend">
                    <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                        title="Name of this device"><span data-feather="target"></span></div>
                </div>
                <input class="form-control" placeholder="Device Name" name="name">
            </div>

            <div class="input-group mt-1">
                <div class="input-group-prepend">
                    <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                        title="Phone number of this device"><span data-feather="phone"></span></div>
                </div>
                <input class="form-control" placeholder="Device Tel Number" name="tel">
            </div>

            <br>

            <div class="row">
                <div class="col-md-1">
                    <div class="" data-toggle="tooltip" data-placement="top"
                        title="Time to receive the alert in seconds, from 0 to 60">? time</div>
                </div>

                <div class="col-md-9">

                    <input type="range" class="custom-range" name="t" min="0" step="5" max="60" value="20"
                        oninput="this.form.t_input.value=this.value">
                </div>
                <div class="col-md-1">
                    <input class="border-0 input-sm" type="number" name="t_input" min="0" step="5" max="60" value="20"
                        oninput="this.form.t.value=this.value">

                </div>


            </div>


            <div class="row">
                <div class="col-md-1">
                    <div class="" data-toggle="tooltip" data-placement="top"
                        title="Minimal distance to Associated Fence, from 10 to 50 meters ">? dist</div>
                </div>

                <div class="col-md-9">

                    <input type="range" class="custom-range" name="d" min="10" step="5" max="50" value="20"
                        oninput="this.form.d_input.value=this.value">
                </div>
                <div class="col-md-1">
                    <input class="border-0 input-sm" type="number" name="d_input" min="10" step="5" max="50" value="20"
                        oninput="this.form.d.value=this.value">

                </div>

            </div>


            <div class="row">
                <div class="col-md-1">
                    <div class="" data-toggle="tooltip" data-placement="top" title="Radius of the Personal Area, from 1 to 5 meters,
                    used to fire a meet event with others registered Users">? radius</div>
                </div>
                <div class="col-md-9">

                    <input type="range" class="custom-range" name="r" min="1" step=".5" max="5" value="2"
                        oninput="this.form.r_input.value=this.value">
                </div>
                <div class="col-md-1">
                    <input class="border-0 input-sm" type="number" name="r_input" min="1" step=".5" max="5" value="2"
                        oninput="this.form.r.value=this.value">

                </div>
            </div>


            <div class="input-group my-3">
                <div class="input-group-prepend">
                    <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                        title="Partners, assign numbers that will not be computed, if occurs a meeting inside your personal circle">
                        <span data-feather="user"></span></div>
                </div>
                <input class="form-control" placeholder="Partners Tels on the format XXYYYYYYYYY, XXYYYYYYYYY, ..."
                    name="partners">
            </div>



            <div class="input-group my-2">
                <div class="input-group-prepend">
                    <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                        title="Associated Fences for this Device">?</div>
                </div>
                <select title="Fences Associated to this Device" name="fences_id[]"
                    class="form-control border border-info selectpicker" multiple>
                    <?php
                    foreach ($fences as $fence):
                        echo sprintf("<option value='%d'>%s</option>",$fence->id,$fence->name);
                    endforeach;
                    ?>
                </select>
            </div>

            <button class="btn mt-2 btn-lg btn-success">create</button>
        </form>


    </div>
</div> -->

<br>

<?php echo $__env->make('shared.header', ['name' => 'Edit your Devices'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<?php if($loop->first): ?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <?php endif; ?>
        <div class="col-auto mb-3">
            <div class="card p-0 vitrine" style="width: 20rem;">
                <div class="card-body p-2">
                    <form method="POST" action="<?php echo e(route('device.update',['device'=>$device->id])); ?>">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>

                        <div class="input-group mt-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                                    title="Name of this device"><span data-feather="user"></span></div>
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



<!--                         <div class="row">
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
                                <div class="" data-toggle="tooltip" data-placement="top" title="Radius of the Personal Area, from 1 to 5 meters,
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
                        <div class="input-group my-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text" data-toggle="tooltip" data-placement="top"
                                    title="Partners, assign numbers that will not be computed, if occurs a meeting inside your personal circle">
                                    <span data-feather="user"></span>
                                </div>
                            </div>
                            <?php $partners = ''; ?>
                            <?php $__currentLoopData = $device->partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $partners .= $v.','; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $partners = trim($partners,','); ?>
                            <?php $partners = trim($partners,'"'); ?>


                            <input class="form-control" value="<?php echo e($partners); ?>"
                                placeholder="XXYYYYYYYYY, XXYYYYYYYYY, ..." name="partners">
                        </div>
                        <select title="Fences Associated to this Device" name="fences_id[]"
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
                        </select> -->




                        <button class="btn mt-2 btn-sm btn-success">save</button>
                    </form>

                </div>
                <div class="card-footer">
                    <form method="POST" action="<?php echo e(route('device.destroy',['device'=>$device])); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>

                        <a href="<?php echo e(route('device.show',['device'=>$device] )); ?>" class="btn mr-2 btn-sm btn-info">
                            edit
                        </a>


                        <?php if(count($device->fences)>0): ?>
                        <a href="#" class="mr-2 btn btn-sm btn-primary" data-cercas="<?php echo e($device->fences ?? false); ?>"
                            data-name="<?php echo e($device->name); ?>" data-toggle="modal" data-target="#device_modal">
                            is tracked
                        </a>
                        <?php else: ?>
                            not tracked
                        <?php endif; ?>

                        <button class="btn ml-2 btn-sm btn-danger">del</button>

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


<div class="modal fade" id="update_modal" tabindex="-1" role="dialog"
    aria-labelledby="update_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_header">Edit and Configure</h5>
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('API_GOOGLE')); ?>" async defer></script>
<script>

    $('#update_modal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget)
        var device_id = button.data('device_id');
        $("#label_header").text('Edit: '+device_id);


    });







    $('#device_modal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget)
        var cercas = button.data('cercas');
        var label_device = button.data('name');
        $("#label_cerca").text(label_device);

        var center_cerca = JSON.parse(cercas[0].fence);
        var center = { 'lat': parseFloat(center_cerca[0].lat), 'lng': parseFloat(center_cerca[0].lng) };

        var map = new google.maps.Map(document.getElementById('map_cerca'), {
            center: center,
            zoom: 16,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false
        });


        Array.prototype.sample = function () {
            return this[Math.floor(Math.random() * this.length)];
        }

        var cores = ['red', 'orange', 'purple', 'green', 'blue', 'yellow', 'navy', 'teal'];

        for (let i = 0; i < cercas.length; i++) {
            var path = JSON.parse(cercas[i].fence);
            var cor = cores.sample();
            var pl = new google.maps.Polygon({
                path: path,
                strokeColor: cor,
                fillColor: cor,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillOpacity: 0.1
            });

            pl.setMap(map);
        }
    });


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/device/index.blade.php ENDPATH**/ ?>