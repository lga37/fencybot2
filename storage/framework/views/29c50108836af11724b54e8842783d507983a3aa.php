<?php $__env->startSection('css'); ?>
<style>
    input[type="range"] {
        cursor: pointer;
    }

    .menu {

        background-color: white;
        border: 2px solid black;
        padding: 5px;

    }

    .pre_range {
        background: white;

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
        background: white;
    }

    .fences {
        background-color: rgba(0, 255, 0, 0.3);
    }

    .devices {
        background-color: rgba(255, 0, 0, 0.3);
    }

    .circle1 {
        border: 1px solid green;
        background-color: rgba(0, 255, 0, 0.3);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;

        padding: 0px;
        margin: 0px;
        z-index: 1;
        left: 65%;
        top: 30%;
        transform: translate(-60%, -30%);
        height: 290px;
        width: 290px;
        position: relative;

    }

    .circle2 {
        border: 1px solid red;
        background-color: rgba(255, 0, 0, 0.3);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0px;
        margin: 0px;
        z-index: 1;
        left: 55%;
        top: 30%;
        transform: translate(-60%, -30%);
        height: 290px;
        width: 290px;
        position: absolute;

    }

    .circle3 {
        border: 1px solid blue;
        background-color: rgba(0, 0, 255, 0.3);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0px;
        margin: 0px;
        z-index: 1;
        left: 50%;
        top: 30%;
        transform: translate(-60%, -30%);
        height: 290px;
        width: 290px;
        position: absolute;

    }



    .fences_partners {
        background: white;
        position: relative;
        width: 95%;
        margin-top: 5px;
        padding: 3px;
        border: 0px solid black;
        z-index: 2;
    }

    [data-draggable="item"] {
        cursor: all-scroll;
        display: block;

        border: 1px dotted black;
        width: 150px;

        margin: 0 0 4px 0;
        padding: 0.2em 0.4em;
        border-radius: 0.2em;
        line-height: 1.4;

    }

    .box {
        border: 2px solid black;
        background-color: white;
        width: 99%;
        padding: 12px;

    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Drag and Drop to Configure Device'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<p>
    You are editing <b><?php echo e($device->name); ?></b>. Switch to :

    <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if($d->id != $device->id): ?>
    <?php if(!$loop->last && !$loop->first): ?>
    ,
    <?php endif; ?>
    <a href="<?php echo e(route('device.show',['device'=>$d])); ?>"><?php echo e($d->name); ?></a>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
</p>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 ">
            <form method="POST" id="myForm" action="<?php echo e(route('device.configure')); ?>">
                <input type="hidden" name="device_id" value="<?php echo e($device->id); ?>">
                <div class="menu ">
                    <b>Fences</b> to <?php echo e($device->name); ?> <?php echo e($device->tel); ?>

                    <div class="" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $nao_fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <span class="devices" data-fencedevice_id="<?php echo e($fence['id']); ?>" data-draggable="item"><span
                                data-feather="map-pin"></span> <?php echo e($fence['name']); ?></span>


                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><b>None</b></p>
                        <?php endif; ?>


                    </div>
                    <hr>
                    <b>Partners Devices</b>
                    <div class="" data-draggable="target">
                        <?php $__empty_1 = true; $__currentLoopData = $nao_partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nao_partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($nao_partner['id'] != $device->id): ?>
                        <span class="fences" data-device_partner_id="<?php echo e($nao_partner['id']); ?>"
                            data-draggable="item"><span data-feather="target"></span> <?php echo e($nao_partner['name']); ?></span>

                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><b>None</b></p>
                        <?php endif; ?>
                    </div>

                </div>

        </div>
        <div class="col-md-9 ">
            <div class="row">

                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="circle1">
                                <img width="65" style="position:absolute;" src="<?php echo e(asset('images/33308.svg')); ?>" alt="">
                                <br><br><br><br><br><br>
                                Partners Devices
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="circle2 text-center">
                                <img width="55" style="position:absolute;" class=""
                                    src="<?php echo e(asset('images/1077114.svg')); ?>" alt="">
                                <br><br><br><br><br>
                                <?php echo e($device->name); ?><br>
                                <?php echo e($device->tel); ?><br>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="circle3">
                                <img width="85" style="position:absolute;" src="<?php echo e(asset('images/32441.svg')); ?>" alt="">
                                <br><br><br><br><br><br>
                                Strangers
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-4" style="background-color: rgba(0, 255, 0, 0.3);">
                                    <div class="fences_partners">
                                        <b>Drag and Drop Partners Devices here</b>
                                        <div class="box" id="devices_partners" data-draggable="target">
                                            <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <span class="fences" data-device_partner_id="<?php echo e($partner['id']); ?>"
                                                data-draggable="item"><span data-feather="target"></span>
                                                <?php echo e($partner['name']); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="p-1 mt-2">
                                        Waiting time for alert, in seconds:
                                        <div class="row">
                                            <div class="col-md-1 pre_range">
                                                <div class="" data-toggle="tooltip" data-placement="top"
                                                    title="Time to wait in the app to confirm that the user is really out of the fence.
                                                    If leaves quickly and returns within that time, the app will disregard the exit.
                                                    From 0 to 60">0</div>
                                            </div>
                                            <div class="col-md-9 range">
                                                <input type="range" class="custom-range" id="time" name="t" min="0"
                                                    step="5" max="60" value="<?php echo e($device->t); ?>"
                                                    oninput="this.form.t_input.value=this.value">
                                            </div>
                                            <div class="col-md-1 pos_range">
                                                <input class="border-0 input-sm pos_input_range pl-0" type="number"
                                                    id="time_input" name="t_input" value="<?php echo e($device->t); ?>" min="0"
                                                    step="5" max="60" oninput="this.form.t.value=this.value">
                                            </div>
                                        </div>
                                        <br>

                                        Minimal distance to the edge of Associated Fence:
                                        <div class="row">
                                            <div class="col-md-1 pre_range">
                                                <div class="" data-toggle="tooltip" data-placement="top"
                                                    title="Minimal distance to Associated Fence, from 10 to 50 meters">
                                                    10
                                                </div>
                                            </div>
                                            <div class="col-md-9 range">
                                                <input type="range" class="custom-range" id="dist" name="d" min="10"
                                                    step="5" max="50" value="<?php echo e($device->d); ?>"
                                                    oninput="this.form.d_input.value=this.value">
                                            </div>
                                            <div class="col-md-1 pos_range">
                                                <input class="border-0 input-sm pos_input_range pl-0" type="number"
                                                    id="dist_input" name="d_input" value="<?php echo e($device->d); ?>" min="10"
                                                    step="5" max="50" oninput="this.form.d.value=this.value">
                                            </div>
                                        </div>

                                    </div>




                                </div>
                                <div class="col-md-4 " style="background-color: rgba(255, 0, 0, 0.3);">

                                    <div class="fences_partners">
                                        <b>Drag and Drop Fences here</b>
                                        <div class="box" id="associated_fences" data-draggable="target">
                                            <?php $__empty_1 = true; $__currentLoopData = $fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fencedevice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <span class="devices" data-fencedevice_id="<?php echo e($fencedevice['id']); ?>"
                                                data-draggable="item"><span data-feather="map-pin"></span>
                                                <?php echo e($fencedevice['name']); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 pt-1" style="background-color: rgba(0, 0, 255, 0.3);">
                                    Personal Fence Size

                                    <?php echo e($device->r); ?>


                                    <div class="custom-control custom-switch">
                                        <input type="radio" id="radius_1" name="r" value="1" <?php echo e($device->r==1? 'checked':''); ?>>
                                        <label for="radius_1">Close</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="radius_2" name="r" value="2" <?php echo e($device->r==2 || !isset($device->r) ? 'checked':''); ?>>

                                        <label for="radius_2">Very Close</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>


        <button class="btn mt-2 btn-lg btn-block btn-info">SAVE & UPDATE</button>
        </form>


        <!--
        <i class="material-icons" style="font-size:60px;color:red;">cloud</i><br>
        <i class="material-icons" style="font-size:60px;color:red;">notifications</i><br>
        <i class="material-icons" style="font-size:60px;color:red;">person_add_alt_1</i><br>
        <i class="material-icons" style="font-size:60px;color:red;">add_location_alt</i><br>
-->


        <?php $__env->stopSection(); ?>

        <?php $__env->startSection('js'); ?>

        <script>



            $('#checkRdistance').on('change', function () {
                //$(this).toggle();

                $(this).toggle(
                    function () {
                        $(".circle3").css({ left: "30%" });
                    },
                    function () {
                        $(".circle3").css({ left: "50%" });
                    }
                );


            });





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