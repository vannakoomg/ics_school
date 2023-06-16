<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1><?php echo e(trans('panel.site_title'), false); ?></h1>

                <p class="text-muted"><?php echo e(trans('global.reset_password'), false); ?></p>

                <form method="POST" action="<?php echo e(route('password.request'), false); ?>">
                    <?php echo csrf_field(); ?>

                    <input name="token" value="<?php echo e($token, false); ?>" type="hidden">

                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : '', false); ?>" required autocomplete="email" autofocus placeholder="<?php echo e(trans('global.login_email'), false); ?>" value="<?php echo e($email ?? old('email'), false); ?>">

                        <?php if($errors->has('email')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('email'), false); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" name="password" class="form-control" required placeholder="<?php echo e(trans('global.login_password'), false); ?>">

                        <?php if($errors->has('password')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('password'), false); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required placeholder="<?php echo e(trans('global.login_password_confirmation'), false); ?>">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                <?php echo e(trans('global.reset_password'), false); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>