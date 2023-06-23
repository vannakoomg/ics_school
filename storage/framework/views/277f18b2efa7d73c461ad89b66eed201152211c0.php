

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="gallary/create">
                    <?php echo e(trans('global.add'), false); ?> <?php echo e(trans('cruds.schoolClass.title_singular'), false); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <?php $__currentLoopData = $folder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folldername): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
                <div class="col-sm">
                    <?php echo e($folldername->title, false); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/gallary/index.blade.php ENDPATH**/ ?>