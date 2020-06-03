<?php $__env->startSection('content'); ?>

<?php if(session('status')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>

<h2 class="shadow p-3 m-3 bg-white rounded-lg border border-info rounded">Change Password </h2>

<form method="POST" action="<?php echo e(route('user.savepass')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group row">
        <label for="password" class="col-md-2 col-form-label text-md-right"><?php echo e(__('New Password')); ?></label>

        <div class="col-md-10">
            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                name="password" required autocomplete="new-password">

            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback" role="alert">
                <strong><?php echo e($message); ?></strong>
            </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-2 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

        <div class="col-md-10">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">

        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                <?php echo e(__('Register')); ?>

            </button>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cerca/resources/views/user/changepass.blade.php ENDPATH**/ ?>