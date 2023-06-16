<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.edit'), false); ?> <?php echo e(trans('cruds.permission.title_singular'), false); ?>

    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("admin.permissions.update", [$permission->id]), false); ?>" enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="required" for="title"><?php echo e(trans('cruds.permission.fields.title'), false); ?></label>
                <input class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : '', false); ?>" type="text" name="title" id="title" value="<?php echo e(old('title', $permission->title), false); ?>" required>
                <?php if($errors->has('title')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('title'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.permission.fields.title_helper'), false); ?></span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    <?php echo e(trans('global.save'), false); ?>

                </button>
            </div>
        </form>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/disk2/www/school/resources/views/admin/permissions/edit.blade.php ENDPATH**/ ?>