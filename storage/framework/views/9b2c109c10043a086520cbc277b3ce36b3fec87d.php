<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route("admin.users.create"), false); ?>">
                <?php echo e(trans('global.add'), false); ?> <?php echo e(trans('cruds.user.title_singular'), false); ?>

            </a>
        </div>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('cruds.user.title_singular'), false); ?> <?php echo e(trans('global.list'), false); ?>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.id'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.name'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.email'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.email_verified_at'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.roles'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.class'), false); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($user->id, false); ?>">
                            <td>

                            </td>
                            <td>
                                <?php echo e($user->id ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($user->name ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($user->email ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($user->email_verified_at ?? '', false); ?>

                            </td>
                            <td>
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-info"><?php echo e($item->title, false); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td>
                                <?php echo e($user->class->name ?? '', false); ?>

                            </td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_show')): ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.users.show', $user->id), false); ?>">
                                        <?php echo e(trans('global.view'), false); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_edit')): ?>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.users.edit', $user->id), false); ?>">
                                        <?php echo e(trans('global.edit'), false); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                        <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
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

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.users.massDestroy'), false); ?>",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('<?php echo e(trans('global.datatables.zero_selected'), false); ?>')

        return
      }

      if (confirm('<?php echo e(trans('global.areYouSure'), false); ?>')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
<?php endif; ?>

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<?php $__env->stopSection(); ?><?php /**PATH /mnt/disk2/www/school/resources/views/admin/roles/relationships/rolesUsers.blade.php ENDPATH**/ ?>