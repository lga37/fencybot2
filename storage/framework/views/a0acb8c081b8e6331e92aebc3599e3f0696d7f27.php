<?php $__env->startSection('css'); ?>
<style>
    .vitrine:hover {
        border: 1px solid blue;
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('shared.header', ['name' => 'Add new Device'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="container">
    <form method="POST" action="<?php echo e(route('device.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="input-group mt-1">
            <div class="input-group-prepend">
                <div class="input-group-text" data-toggle="tooltip" data-placement="top" title="Name of this device">Add
                    New
                    Device</div>
            </div>
            <div class="input-group-prepend ml-1">
                <div class="input-group-text" data-toggle="tooltip" data-placement="top" title="Name of this device">
                    <span data-feather="target"></span></div>
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

</div>


<br>

<?php echo $__env->make('shared.header', ['name' => 'Edit your Devices'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="row">
    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => 'Trackeds'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <table class="table table-striped table-sm">
            <tr>
                <thead>
                    <th>id</th>
                    <th>name</th>
                    <th>tel</th>
                    <th>save</th>
                    <th>untrack</th>
                    <th>edit</th>
                    <th>del</th>
                </thead>
            </tr>
            <?php $__empty_1 = true; $__currentLoopData = $trackeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tracked): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($tracked->id); ?></td>

                <form method="POST" action="<?php echo e(route('device.patch',['device'=>$tracked->id])); ?>">
                    <?php echo csrf_field(); ?>
                    <td>
                        <input class="form-control" name="name" value="<?php echo e($tracked->name); ?>">
                    </td>
                    <td>
                        <input class="form-control" name="tel" value="<?php echo e($tracked->tel); ?>">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-success">Save</button>
                    </td>
                </form>

                <td>
                    <form method="POST" action="<?php echo e(route('device.untrack',['device'=>$tracked->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-sm btn-info">untrack</button>
                    </form>

                </td>

                <td>
                    <a href="<?php echo e(route('device.show',['device'=>$tracked] )); ?>" class="btn btn-sm btn-warning">
                        edit
                    </a>
                </td>


                <td>
                    <form method="POST" action="<?php echo e(route('device.destroy',['device'=>$tracked])); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>

                        <button class="btn btn-sm btn-outline-danger">del</button>
                    </form>

                </td>


            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p><b>No records</b></p>

            <?php endif; ?>

        </table>
    </div>


    <div class="col-md-6">
        <?php echo $__env->make('shared.header', ['name' => 'UnTrackeds'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>tel</th>
                    <th>save</th>
                    <th>track</th>
                    <th>del</th>
                </tr>
            </thead>
            <?php $__empty_1 = true; $__currentLoopData = $not_trackeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $not_tracked): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($not_tracked->id); ?></td>
                <form method="POST" action="<?php echo e(route('device.patch',['device'=>$not_tracked->id])); ?>">
                    <?php echo csrf_field(); ?>
                    <td>
                        <input class="form-control" name="name" value="<?php echo e($not_tracked->name); ?>">
                    </td>
                    <td>
                        <input class="form-control" name="tel" value="<?php echo e($not_tracked->tel); ?>">
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-success">Save</button>
                    </td>
                </form>

                <td>
                    <a href="<?php echo e(route('device.show',['device'=>$not_tracked] )); ?>" class="btn btn-sm btn-info">
                        track
                    </a>
                </td>


                <td>
                    <form method="POST" action="<?php echo e(route('device.destroy',['device'=>$not_tracked])); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>

                        <button class="btn btn-sm btn-outline-danger">del</button>
                    </form>

                </td>
            </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p><b>No records</b></p>

            <?php endif; ?>

        </table>
    </div>
</div>

<!-- ----------------------------------------- card -->
<br><br><br><br><br><br><br><br><br><br><br><br><br>
vou tirar depoissssss

<?php $__empty_1 = true; $__currentLoopData = $trackeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

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
<?php endif; ?>


<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="update_modal" aria-hidden="true">
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
        $("#label_header").text('Edit: ' + device_id);


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