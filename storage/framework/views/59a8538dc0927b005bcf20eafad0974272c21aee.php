
<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4 bg-primary">
                    <h1><?php echo e(trans('panel.site_title'), false); ?></h1>

                    <p class="text-white"><?php echo e(trans('global.login'), false); ?></p>

                    <?php if(session('message')): ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo e(session('message'), false); ?>

                        </div>
                    <?php endif; ?>


                    <form method="POST" action="<?php echo e(route('login'), false); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>

                            <input id="email" name="email" type="text"
                                class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : '', false); ?>" required
                                autocomplete="email" autofocus placeholder="<?php echo e(trans('global.login_email'), false); ?>"
                                value="<?php echo e(old('email', null), false); ?>">

                            <?php if($errors->has('email')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('email'), false); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>

                            <input id="password" name="password" type="password"
                                class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : '', false); ?>" required
                                placeholder="<?php echo e(trans('global.login_password'), false); ?>">

                            <?php if($errors->has('password')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('password'), false); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group mb-4">
                            <div class="form-check checkbox">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                    style="vertical-align: middle;" />
                                <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                    <?php echo e(trans('global.remember_me'), false); ?>

                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-light px-4">
                                    <?php echo e(trans('global.login'), false); ?>

                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <?php if(Route::has('password.request')): ?>
                                    <a class="btn btn-link px-0" href="<?php echo e(route('password.request'), false); ?>">
                                        <?php echo e(trans('global.forgot_password'), false); ?>

                                    </a><br>
                                <?php endif; ?>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/auth/login.blade.php ENDPATH**/ ?>