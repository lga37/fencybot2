<?php $__env->startSection('content'); ?>

<?php echo $__env->make('shared.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('shared.header', ['name' => 'Profile'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<form method="POST" action="<?php echo e(route('user.update')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label text-md-right"><?php echo e(__('Name')); ?></label>
        <div class="col-md-10">
            <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                value="<?php echo e($user->name ?? old('name')); ?>" required autocomplete="name" autofocus>

            <?php $__errorArgs = ['name'];
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
        <input type="hidden" id="code" name="code" value="1">
        <label for="tel" class="col-md-2 col-form-label text-md-right"><?php echo e(__('Tel')); ?></label>

        <div class="col-md-10">
            <input type="text"
            class="form-control <?php $__errorArgs = ['tel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tel"
                value="<?php echo e($user->tel ?? old('tel')); ?>" required autocomplete="tel" autofocus>

            <?php $__errorArgs = ['tel'];
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






    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                Save
            </button>
        </div>
    </div>
</form>
<br>

<?php echo $__env->make('shared.header', ['name' => 'Change Email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<form method="POST" action="<?php echo e(route('user.emailchange')); ?>">
    <?php echo csrf_field(); ?>

    <div class="form-group row">
        <label for="email" class="col-md-2 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?></label>

        <div class="col-md-10">
            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                value="<?php echo e($user->email ?? old('email')); ?>" required autocomplete="email">

            <?php $__errorArgs = ['email'];
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


    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                Save
            </button>
        </div>
    </div>
</form>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

<script>
/*     var input = document.querySelector("#tel");

    window.intlTelInput(input, {

        preferredCountries: ["us", "br"],
            separateDialCode: true,
            initialCountry: "br",
            separateDialCode: true,

        })
        .on('countrychange', function (e, countryData) {
            $("#code").val((
                $("#tel")
            .intlTelInput("getSelectedCountryData").dialCode));

    });
 */</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/user/profile.blade.php ENDPATH**/ ?>