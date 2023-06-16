<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.show'), false); ?> <?php echo e(trans('cruds.role.title'), false); ?>

    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.roles.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.role.fields.id'), false); ?>

                        </th>
                        <td>
                            <?php echo e($role->id, false); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.role.fields.title'), false); ?>

                        </th>
                        <td>
                            <?php echo e($role->title, false); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.role.fields.permissions'), false); ?>

                        </th>
                        <td>
                            <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="label label-info"><?php echo e($permissions->title, false); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.roles.index'), false); ?>">
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
            <a class="nav-link" href="#roles_users" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.user.title'), false); ?>

            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="roles_users">
            <?php if ($__env->exists('admin.roles.relationships.rolesUsers', ['users' => $role->rolesUsers])) echo $__env->make('admin.roles.relationships.rolesUsers', ['users' => $role->rolesUsers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/disk2/www/school/resources/views/admin/roles/show.blade.php ENDPATH**/ ?>