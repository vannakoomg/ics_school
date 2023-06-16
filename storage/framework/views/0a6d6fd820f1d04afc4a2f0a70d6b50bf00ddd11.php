<?php $__env->startSection('content'); ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route("admin.lessons.create")); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.lesson.title_singular')); ?>

            </a>
        </div>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-header">
        <?php echo e(trans('cruds.lesson.title_singular')); ?> <?php echo e(trans('global.list')); ?>

    </div>
    <?php
         $days = [1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday'];
    ?>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.id')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.class')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.teacher')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.weekday')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.start_time')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.end_time')); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($lesson->id); ?>">
                            <td>

                            </td>
                            <td>
                                <?php echo e($lesson->id ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->class->name ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->teacher->name ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($days[$lesson->weekday] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->start_time ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->end_time ?? ''); ?>

                            </td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_show')): ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.lessons.show', $lesson->id)); ?>">
                                        <?php echo e(trans('global.view')); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_edit')): ?>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.lessons.edit', $lesson->id)); ?>">
                                        <?php echo e(trans('global.edit')); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_delete')): ?>
                                    <form action="<?php echo e(route('admin.lessons.destroy', $lesson->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete')); ?>">
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
<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete')); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.lessons.massDestroy')); ?>",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('<?php echo e(trans('global.datatables.zero_selected')); ?>')

        return
      }

      if (confirm('<?php echo e(trans('global.areYouSure')); ?>')) {
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
  $('.datatable-Lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/icsapp/resources/views/admin/lessons/index.blade.php ENDPATH**/ ?>