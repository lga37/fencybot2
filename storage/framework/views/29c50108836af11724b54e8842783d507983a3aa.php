<?php $__env->startSection('css'); ?>
<style>
    .circle2 {
        border-radius: 50%;
    }

    input[type="range"] {
        cursor: pointer;
    }

    .menu {
        border: 0px dotted black;
        height: 600px;
    }

    .pre_range {
        background: #ccc;
    }

    .range {
        margin: 0;
        padding: 0;
    }

    .pos_range {
        padding: 0;
    }

    .pos_input_range {
        padding: 0;
        width: 35px;
        height: 25px;
        text-align: center;
        background: #ccc;
    }

    .circle {
        border: 1px solid #000;
        background-color: rgba(0, 142, 0, 0.3);
        border-radius: 50%;


        display: flex;
        justify-content: center;
        align-items: center;

        padding: 15px;
        margin: 5px;
        z-index: 1;
        left: 50%;
        top: 20%;
        transform: translate(-60%, -30%);
        height: 370px;
        width: 370px;
        position: absolute;

    }

    .dentro {
        position: relative;
        z-index: 2;
        text-align: center;

        padding: 7px;
        color: cornflowerblue;
        background-color: black;
        width: 220px;
        height: 70px;
        border-radius: 5%;
    }

    .fences_partners {
        position: relative;
        width: 220px;
        border: 0px dotted black;
        z-index: 2;
    }


    [data-draggable="item"] {
        cursor: all-scroll;
        display: block;

        border: 1px dotted black;
        background-color: #ccc;
        width: 150px;

        margin: 0 0 4px 0;
        padding: 0.2em 0.4em;
        border-radius: 0.2em;
        line-height: 1.4;
    }

    .box {

        border: 2px solid blue;
        background-color: lightblue;
        width: 99%;
        padding: 12px;

    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Drag and Drop on Blue Area to Configure Device'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <form method="POST" id="myForm" action="<?php echo e(route('device.configure')); ?>">
                <input type="hidden" name="device_id" value="<?php echo e($device->id); ?>">
                <div class="menu">
                    <b>Fences</b> (to monitore)
                    <div class="box" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $nao_fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <span data-fencedevice_id="<?php echo e($fence['id']); ?>" data-draggable="item"><span
                                data-feather="map-pin"></span> <?php echo e($fence['name']); ?></span>


                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><b>No Fences</b></p>
                        <?php endif; ?>


                    </div>
                    <hr>
                    <b>Devices</b> (to silent if meet)
                    <div class="box" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $nao_partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nao_partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($nao_partner['id'] != $device->id): ?>
                        <span data-device_partner_id="<?php echo e($nao_partner['id']); ?>" data-draggable="item"><span
                                data-feather="target"></span> <?php echo e($nao_partner['name']); ?></span>

                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><b>No Devices</b></p>
                        <?php endif; ?>
                    </div>
                    <br>

                    Dimension of personal Fence (Default is close)

                    <div class="custom-control custom-switch">


                        <input type="checkbox" value="1" name="r"
                        class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label"
                        for="customSwitch1">Very Close</label>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-1 pre_range">
                            <div class="" data-toggle="tooltip" data-placement="top" title="Radius of the Personal Area, from 1 to 5 meters,
                            used to fire a meet event with others registered Users">?</div>
                        </div>
                        <div class="col-md-9 range">
                            <input type="range" class="custom-range" id="radius" name="rrr" min="1" step=".5" max="5"
                                value="<?php echo e($device->r); ?>" oninput="this.form.r_input.value=this.value">
                        </div>
                        <div class="col-md-1 pos_range">
                            <input class="border-0 input-sm pos_input_range pl-0" type="number" id="radius_input"
                                name="r_input" min="1" step=".5" max="5" value="<?php echo e($device->r); ?>"
                                oninput="this.form.r.value=this.value">
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-1 pre_range">
                            <div class="" data-toggle="tooltip" data-placement="top"
                                title="Time to receive the alert in seconds, from 0 to 60">?</div>
                        </div>
                        <div class="col-md-9 range">
                            <input type="range" class="custom-range" id="time" name="t" min="0" step="5" max="60"
                                value="<?php echo e($device->t); ?>" oninput="this.form.t_input.value=this.value">
                        </div>
                        <div class="col-md-1 pos_range">
                            <input class="border-0 input-sm pos_input_range pl-0" type="number" id="time_input"
                                name="t_input" value="<?php echo e($device->t); ?>" min="0" step="5" max="60"
                                oninput="this.form.t.value=this.value">
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-1 pre_range">
                            <div class="" data-toggle="tooltip" data-placement="top"
                                title="Minimal distance to Associated Fence, from 10 to 50 meters">?</div>
                        </div>
                        <div class="col-md-9 range">
                            <input type="range" class="custom-range" id="dist" name="d" min="10" step="5" max="50"
                                value="<?php echo e($device->d); ?>" oninput="this.form.d_input.value=this.value">
                        </div>
                        <div class="col-md-1 pos_range">
                            <input class="border-0 input-sm pos_input_range pl-0" type="number" id="dist_input"
                                name="d_input" value="<?php echo e($device->d); ?>" min="10" step="5" max="50"
                                oninput="this.form.d.value=this.value">
                        </div>
                    </div>

                    <br>


                    <button class="btn mt-2 btn-lg btn-block btn-outline-success">update</button>
                    <!-- <p class="mt-3" style="text-align: center;">----- or ------</p>
                    <button class="btn mt-2 btn-lg btn-block btn-danger">disable tracking</button> -->
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <div class="circle">
            <div class="">
                <div class="dentro">
                    <span data-feather="user"></span> <?php echo e($device->name); ?><br>
                    <span class="" data-feather="phone"></span> <?php echo e($device->tel); ?>

                </div>

                <div class="fences_partners">
                    <b>Associated Fences:</b>
                    <div class="box" id="associated_fences" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fencedevice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span data-fencedevice_id="<?php echo e($fencedevice['id']); ?>" data-draggable="item"><span
                                data-feather="map-pin"></span> <?php echo e($fencedevice['name']); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>

                    <b>Silent Invasions With:</b>
                    <div class="box" id="devices_partners" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span data-device_partner_id="<?php echo e($partner['id']); ?>" data-draggable="item"><span
                                data-feather="target"></span> <?php echo e($partner['name']); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>

                </div>



            </div>

        </div>



    </div>

</div>
</div>






<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script>

    update();

    function update() {
        $(".dynamic").remove();
        $('#associated_fences > span').each(function (v) {
            var j = $(this).data('fencedevice_id');
            $("<input type='hidden' value='" + j + "' >").attr("class", "dynamic").attr("name", "associated_fences[]").appendTo("#myForm");

        });
        $('#devices_partners > span').each(function () {
            var i = $(this).data('device_partner_id');
            $("<input type='hidden' value='" + i + "' >").attr("class", "dynamic").attr("name", "partners[]").appendTo("#myForm");
        });
    }


    (function () {

        if (!document.querySelectorAll || !('draggable' in document.createElement('span')) || window.opera) {
            return;
        }

        for (var items = document.querySelectorAll('[data-draggable="item"]'), len = items.length, i = 0; i < len; i++) {
            items[i].setAttribute('draggable', 'true');
        }

        //variable for storing the dragging item reference this will avoid the need to define any transfer data
        //which means that the elements don't need to have IDs
        var item = null;

        //dragstart event to initiate mouse dragging
        document.addEventListener('dragstart', function (e) {
            //set the item reference to this element
            item = e.target;

            //we don't need the transfer data, but we have to define something
            //otherwise the drop action won't work at all in firefox
            //most browsers support the proper mime-type syntax, eg. "text/plain"
            //but we have to use this incorrect syntax for the benefit of IE10+
            e.dataTransfer.setData('text', '');
            console.log('dragstart:' + e);

        }, false);

        //dragover event to allow the drag by preventing its default
        //ie. the default action of an element is not to allow dragging
        document.addEventListener('dragover', function (e) {
            if (item) {
                e.preventDefault();
            }
            console.log('dragover:' + e);
        }, false);

        //drop event to allow the element to be dropped into valid targets
        document.addEventListener('drop', function (e) {
            //if this element is a drop target, move the item here
            //then prevent default to allow the action (same as dragover)
            if (e.target.getAttribute('data-draggable') == 'target') {
                e.target.appendChild(item);
                e.preventDefault();
            }
            console.log('drop:' + e);
        }, false);

        //dragend event to clean-up after drop or abort
        //which fires whether or not the drop target was valid
        document.addEventListener('dragend', function (e) {
            item = null;


            update();


        }, false);

    })();



    $(function () {

        $('#radius').on('keyup change', function () {
            const $radius = $(this).val();
            var circCss = 0;
            circCss = (200 * $radius);
            $('.circle').css({
                height: parseFloat(circCss),
                width: circCss
            });
        });
    });

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/device/show.blade.php ENDPATH**/ ?>