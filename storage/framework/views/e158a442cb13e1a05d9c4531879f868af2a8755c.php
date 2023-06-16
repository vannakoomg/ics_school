<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.show'), false); ?> <?php echo e(trans('cruds.permission.title'), false); ?>

    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.permissions.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.permission.fields.id'), false); ?>

                        </th>
                        <td>
                            <?php echo e($permission->id, false); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.permission.fields.title'), false); ?>

                        </th>
                        <td>
                            <?php echo e($permission->title, false); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="<?php echo e(route('admin.permissions.index'), false); ?>">
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
            <a class="nav-link" href="#permissions_roles" role="tab" data-toggle="tab">
                <?php echo e(trans('cruds.role.title'), false); ?>

            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="permissions_roles">
            <?php if ($__env->exists('admin.permissions.relationships.permissionsRoles', ['roles' => $permission->permissionsRoles])) echo $__env->make('admin.permissions.relationships.permissionsRoles', ['roles' => $permission->permissionsRoles], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/admin/permissions/show.blade.php ENDPATH**/ ?>