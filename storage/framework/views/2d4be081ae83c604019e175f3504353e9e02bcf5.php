

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.edit'), false); ?>

        </div>
        <div class="card-body container-fluid">
            <form method="POST" action=<?php echo e(route('admin.eventsType.update', $eventsType->id), false); ?> enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="name">title</label>
                            <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text"
                                name="name" id="name" value="<?php echo e($eventsType->name, false); ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="color">Color Code</label>
                            <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text"
                                name="color" id="color" value="<?php echo e($eventsType->color, false); ?>" required>
                        </div>
                    </div>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/eventType/edit.blade.php ENDPATH**/ ?>