

<?php $__env->startSection('content'); ?>
    <div class="card">

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                <?php echo e(trans('cruds.schoolClass.fields.name'), false); ?>

                            </th>
                            <th>
                                Color Code
                            </th>

                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $eventsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($type->id, false); ?>">
                                <td>
                                </td>
                                <td>
                                    <?php echo e($type->name ?? '', false); ?>

                                </td>
                                <td>
                                    <?php echo e($type->color ?? '', false); ?>

                                </td>

                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_edit')): ?>
                                        <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.school-classes.edit', $type->id), false); ?>">
                                            <?php echo e(trans('global.edit'), false); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_delete')): ?>
                                        <form action="<?php echo e(route('admin.school-classes.destroy', $type->id), false); ?>" method="POST"
                                            onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="<?php echo e(trans('global.delete'), false); ?>">
                                        </form>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/events/event_type/index.blade.php ENDPATH**/ ?>