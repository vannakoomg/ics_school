<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.show'), false); ?> <?php echo e(trans('cruds.schoolClass.title'), false); ?>

    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.school-classes.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.schoolClass.fields.id'), false); ?>

                        </th>
                        <td>
                            <?php echo e($schoolClass->id, false); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.schoolClass.fields.name'), false); ?>

                        </th>
                        <td>
                            <?php echo e($schoolClass->name, false); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.school-classes.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.relatedData'), false); ?>

    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#class_lessons" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.lesson.title'), false); ?>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#class_users" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.user.title'), false); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/schoolClasses/show.blade.php ENDPATH**/ ?>