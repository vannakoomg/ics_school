

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.create'), false); ?> Schedule Template
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("admin.scheduletemplate.store"), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
         
<div class="row">
    <div class="col-6">
            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('cruds.schoolClass.fields.name'), false); ?></label>
                <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text" name="name" id="name" value="<?php echo e(old('name', ''), false); ?>" required>
                <?php if($errors->has('name')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('name'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.schoolClass.fields.name_helper'), false); ?></span>
            </div>
    </div>
    <div class="col-6">
            <div class="form-group">
                <label class="required" for="type">Type</label>
                    <select name='type' class="custom-select select2">
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type, false); ?>"><?php echo e($type, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/scheduletemplate/create.blade.php ENDPATH**/ ?>