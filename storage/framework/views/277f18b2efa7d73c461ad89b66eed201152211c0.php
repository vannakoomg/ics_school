
<?php $__env->startSection('styles'); ?>
    <style>
        .card {
            height: fit-content;
            display: flex;
            flex-direction: column;
            padding: 1rem 1rem 2rem;
            background: #f8f3e8;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2), 0 0 40px rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .card>img {
            width: 100%;
            height: auto;
            aspect-ratio: 600/300;
        }

        .card>h2 {
            margin-top: 1rem;
            font-family: "Kalam", cursive;
            font-weight: normal;
            font-size: 2rem;
            color: #4a4a7d;
            text-align: center;
        }

        .card>p {
            font-family: "Kalam", cursive;
            font-size: 1rem;
            color: #5e5e89;
            text-align: center;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.gallary.create'), false); ?>">
                    Add Gallary
                </a>
            </div>
        </div>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
        <div class="d-flex flex-wrap">
            <?php $__currentLoopData = $gallary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallarysss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="btn" href="<?php echo e(route('admin.gallary.edit', $gallarysss->id), false); ?>"
                    style="background-color: rgb(128, 132, 132)">
                    <?php echo e($gallarysss->name, false); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/gallary/index.blade.php ENDPATH**/ ?>