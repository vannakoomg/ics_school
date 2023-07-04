

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.school-classes.create'), false); ?>">
                    <?php echo e(trans('global.add'), false); ?> <?php echo e(trans('cruds.schoolClass.title_singular'), false); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <form name="frmcampus" method="get" action="<?php echo e(route('admin.school-classes.index'), false); ?>"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <?php echo e(trans('cruds.schoolClass.title_singular'), false); ?> <?php echo e(trans('global.list'), false); ?>

                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
                            <div class="col-sm-9">
                                <select class="custom-select <?php echo e($errors->has('campus') ? 'is-invalid' : '', false); ?>"
                                    name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                                    <?php $__currentLoopData = $campus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key, false); ?>" <?php echo e(old('campus') == $key ? 'selected' : '', false); ?>

                                            <?php echo e($key == $current_filter['campus'] ? 'selected' : '', false); ?>><?php echo e($key, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

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
                                Campus
                            </th>
                            <th>
                                Group
                            <th>
                                Schedule Template
                            </th>
                            <th>
                                Schedule
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $schoolClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $schoolClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($schoolClass->id, false); ?>">
                                <td>

                                </td>

                                <td>
                                    <?php echo e($schoolClass->name ?? '', false); ?>

                                </td>
                                <td>
                                    <?php echo e($schoolClass->campus ?? '', false); ?>

                                </td>
                                <td>
                                    <?php echo e($schoolClass->level_type ?? '', false); ?>

                                </td>
                                <td>
                                    <?php $__currentLoopData = $schoolClass->schedule_template; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-info"><?php echo e($item->name, false); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <a
                                        href="<?php echo e(route('admin.timetable.create', ['campus' => $schoolClass->campus, 'class_id' => $schoolClass->id]), false); ?>">View
                                        Schedule</a>
                                </td>
                                <td>
                                    

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_edit')): ?>
                                        <a class="btn btn-xs btn-info"
                                            href="<?php echo e(route('admin.school-classes.edit', $schoolClass->id), false); ?>">
                                            <?php echo e(trans('global.edit'), false); ?>

                                        </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_delete')): ?>
                                        <form action="<?php echo e(route('admin.school-classes.destroy', $schoolClass->id), false); ?>"
                                            method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');"
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
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_delete')): ?>
                let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "<?php echo e(route('admin.school-classes.massDestroy'), false); ?>",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('<?php echo e(trans('global.datatables.zero_selected'), false); ?>')

                            return
                        }

                        if (confirm('<?php echo e(trans('global.areYouSure'), false); ?>')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            <?php endif; ?>

            $.extend(true, $.fn.dataTable.defaults, {
                pageLength: 100,
            });

            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/schoolClasses/index.blade.php ENDPATH**/ ?>