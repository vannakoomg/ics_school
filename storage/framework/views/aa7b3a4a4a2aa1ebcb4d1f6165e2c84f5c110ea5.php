

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create'), false); ?>

        </div>

    </div>
    <div class="container">
        <div>

            <form method="POST" action="http://127.0.0.1:8000/admin/gallary" enctype="multipart/form-data">
                <?php echo e(csrf_field(), false); ?>

                <div class="form-group">
                    <label class="required" for="title">title</label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text" name="title"
                        id="title" value="<?php echo e(old('name', ''), false); ?>" required>
                </div>
                <div>
                    <label>Choose Images</label>
                    <input type="file" name="images" multiple>
                </div>
                <hr>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/gallary/create.blade.php ENDPATH**/ ?>