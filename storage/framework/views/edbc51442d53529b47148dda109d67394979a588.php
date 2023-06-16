<?php $__env->startSection('content'); ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route("admin.lessons.create"), false); ?>">
                <?php echo e(trans('global.add'), false); ?> <?php echo e(trans('cruds.lesson.title_singular'), false); ?>

            </a>
        </div>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-header">
        <?php echo e(trans('cruds.lesson.title_singular'), false); ?> <?php echo e(trans('global.list'), false); ?>

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
                            <?php echo e(trans('cruds.lesson.fields.id'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.class'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.teacher'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.weekday'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.start_time'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.lesson.fields.end_time'), false); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($lesson->id, false); ?>">
                            <td>

                            </td>
                            <td>
                                <?php echo e($lesson->id ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->class->name ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->teacher->name ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($days[$lesson->weekday] ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->start_time ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($lesson->end_time ?? '', false); ?>

                            </td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_show')): ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.lessons.show', $lesson->id), false); ?>">
                                        <?php echo e(trans('global.view'), false); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_edit')): ?>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.lessons.edit', $lesson->id), false); ?>">
                                        <?php echo e(trans('global.edit'), false); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_delete')): ?>
                                    <form action="<?php echo e(route('admin.lessons.destroy', $lesson->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
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



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.lessons.massDestroy'), false); ?>",
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
  $('.datatable-Lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/lessons/index.blade.php ENDPATH**/ ?>