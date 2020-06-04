<?php $__env->startSection('content'); ?>

<?php if(session('status')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>




<h1>Devices para usuario </h1>
<table class="table table-striped">
    <tr>
        <th>add</th>
        <th>
            <form method="POST" action="<?php echo e(route('device.store')); ?>">
                <?php echo csrf_field(); ?>
                <select name="fences_id[]" class="form-control rounded-lg border border-secondary selectpicker"
                    multiple>
                    <option selected disabled>Selecione</option>
                    <?php $__empty_1 = true; $__currentLoopData = $fences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($fence->id); ?>"><?php echo e($fence->name); ?> </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                </select>
        </th>

        <th class="">
            <input type="text" name="name" class="form-control">
        </th>
        <th><input type="text" name="tel" class="form-control"></th>
        <th><input type="text" name="d" value="1" class="form-control"></th>
        <th><input type="text" name="r" value="10" class="form-control"></th>
        <th colspan="4" class="">
            <button class="btn btn-block btn-outline-success">add</button>
            </form>
        </th>
    </tr>
    <tr>
        <th>id</th>
        <th>cerca assoc</th>
        <th>name</th>
        <th>tel</th>
        <th>d</th>
        <th>r</th>
        <th>upd</th>
        <th>del</th>
        <th>get</th>
        <th>map</th>
    </tr>

    <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <tr class="">
        <td class=""><?php echo e($device->id); ?></td>
        <td class="">
            <form method="POST" action="<?php echo e(route('device.update',['device'=>$device->id])); ?>">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <select name="fences_id[]" class="form-control border border-info selectpicker" multiple>
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
        </td>
        <td class="">
            <input type="text" name="name" value="<?php echo e($device->name); ?>" class="form-control">
        </td>
        <td class="">
            <input type="text" name="tel" value="<?php echo e($device->tel); ?>" class="form-control">
        </td>
        <td class="">
            <input type="text" name="d" value="<?php echo e($device->d); ?>" class="form-control">
        </td>
        <td class="">
            <input type="text" name="r" value="<?php echo e($device->r); ?>" class="form-control">
        </td>

        <td class="">
            <button class="btn btn-info">upd</button>
            </form>
        </td>

        <td class="">
            <form method="POST" action="<?php echo e(route('device.destroy',['device'=>$device])); ?>">
                <?php echo method_field('DELETE'); ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger">del</button>
            </form>
        </td>
        <td>
            <a target="_blank" href="<?php echo e(route('fence.get',['tel'=>$device->tel])); ?>"
            class="btn btn-warning">get</a>
        </td>
        <td>
            <a target="_blank" href="<?php echo e(route('device.show',['device'=>$device])); ?>"
            class="btn btn-primary">map</a>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="9">Nenhum Registro</td>
    </tr>
    <?php endif; ?>

</table>


<h1>Combinacoes - Devices registrados </h1>

<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>fence</th>
        <th>device</th>
        <th>alerts</th>
        <th>del</th>
    </tr>
    <?php $__empty_1 = true; $__currentLoopData = $fencedevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fencedevice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="hover:bg-gray-700 border-b border-gray-200">
        <td class=""><?php echo e($fencedevice->id); ?> </td>

        <td class=""><?php echo e($fencedevice->fence->name ?? ''); ?> </td>
        <td class=""><?php echo e($fencedevice->device->name ?? ''); ?> </td>

        <td class="">-- nao tem mais fencedevice_id</td>

        <td class="">
            <form method="POST" action="<?php echo e(route('fencedevice.destroy',['fencedevice'=>$fencedevice])); ?>">
                <?php echo method_field('DELETE'); ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger">del</button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="9">Nenhum Registro</td>
    </tr>
    <?php endif; ?>

</table>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cerca/resources/views/device/index.blade.php ENDPATH**/ ?>