<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.show')); ?> <?php echo e(trans('cruds.schoolClass.title')); ?>

    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.school-classes.index')); ?>">
                    <?php echo e(trans('global.back_to_list')); ?>

                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.schoolClass.fields.id')); ?>

                        </th>
                        <td>
                            <?php echo e($schoolClass->id); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.schoolClass.fields.name')); ?>

                        </th>
                        <td>
                            <?php echo e($schoolClass->name); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.school-classes.index')); ?>">
                    <?php echo e(trans('global.back_to_list')); ?>

                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.relatedData')); ?>

    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#class_lessons" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.lesson.title')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#class_users" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.user.title')); ?>

            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="class_lessons">
            <?php if ($__env->exists('admin.schoolClasses.relationships.classLessons', ['lessons' => $schoolClass->classLessons])) echo $__env->make('admin.schoolClasses.relationships.classLessons', ['lessons' => $schoolClass->classLessons], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="tab-pane" role="tabpanel" id="class_users">
            <?php if ($__env->exists('admin.schoolClasses.relationships.classUsers', ['users' => $schoolClass->classUsers])) echo $__env->make('admin.schoolClasses.relationships.classUsers', ['users' => $schoolClass->classUsers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/icsapp/resources/views/admin/schoolClasses/show.blade.php ENDPATH**/ ?>