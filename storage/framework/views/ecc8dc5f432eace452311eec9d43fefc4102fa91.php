

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/xzoom.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('css/magnific-popup.css'), false); ?>" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    <style>
        .khmer_os {
            font-family: 'Noto Sans Khmer', sans-serif;
            font-size: 130%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.course.create'), false); ?>">
                    <?php echo e(trans('global.add'), false); ?> Course
                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <form name="frmcampus" method="get" action="<?php echo e(route('admin.course.index'), false); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        Course <?php echo e(trans('global.list'), false); ?>

                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="required col-sm-3 col-form-label" for="class_id">Category</label>
                            <div class="col-sm-8">
                                <select class="custom-select" name="filter_category" id="filter_category"
                                    onchange="document.forms['frmcampus'].submit()">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category, false); ?>"
                                            <?php echo e(old('filter_category') == $category ? 'selected' : '', false); ?>

                                            <?php echo e($category == $current_filter['category'] ? 'selected' : '', false); ?>><?php echo e($category, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col text-right">
                        <div class="form-group row">
                            <label class="required col-sm-3 col-form-label" for="class_id">Language</label>
                            <div class="col-sm-8">
                                <select class="custom-select" name="filter_language" id="filter_language"
                                    onchange="document.forms['frmcampus'].submit()">
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($language, false); ?>"
                                            <?php echo e(old('filter_language') == $language ? 'selected' : '', false); ?>

                                            <?php echo e($language == $current_filter['language'] ? 'selected' : '', false); ?>><?php echo e($language, false); ?>

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
                <table class=" table table-bordered datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                <?php echo e(trans('cruds.schoolClass.fields.id'), false); ?>

                            </th>
                            <th>
                                Thumbnail
                            </th>
                            <th>
                                Course
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Language Type
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($course->id, false); ?>" bgcolor="<?php echo e($course->color ?? '#FFF', false); ?>">
                                <td>

                                </td>
                                <td>
                                    <?php echo e($course->id ?? '', false); ?>

                                </td>
                                <td>
                                    <div class="xzoom-thumbs text-left">
                                        <?php if(!empty($course->image)): ?>
                                            <img src="<?php echo e(asset('storage/image/' . $course->image), false); ?>"
                                                class="xzoom-gallery img-thumbnail btn btn-outline-primary"
                                                id="img_thumbnail" xpreview="<?php echo e(asset('storage/image' . $course->image), false); ?>"
                                                style="height: 100px !important">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('images/no-image.png'), false); ?>" class="btn btn-outline-primary"
                                                height="100px">
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="khmer_os">
                                    <?php echo e($course->name ?? '', false); ?>

                                </td>
                                <td>
                                    <?php echo e($course->description ?? '', false); ?>

                                </td>

                                <td>
                                    
                                    <?php echo e($course->category ?? '', false); ?>

                                </td>
                                <td>
                                    <?php echo e($course->language ?? '', false); ?>

                                </td>

                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course')): ?>
                                        

                                        <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.course.edit', $course->id), false); ?>">
                                            <?php echo e(trans('global.edit'), false); ?>

                                        </a>

                                        <form action="<?php echo e(route('admin.course.destroy', $course->id), false); ?>" method="POST"
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
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script src="<?php echo e(asset('js/xzoom.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/magnific-popup.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.hammer.min.js'), false); ?>"></script>
    <script>
        $(function() {

            $('.xzoom-gallery').bind('click', function(event) {
                var div = $(this).parents('.xzoom-thumbs');
                // var xzoom = $(this).data('xzoom');
                // xzoom.closezoom();
                // var gallery = xzoom.gallery().cgallery;
                // var i, images = new Array();
                // for (i in gallery) {
                //     images[i] = {src: gallery[i]};
                // }
                images = new Array();

                var img_length = div.find('img').length;
                for (i = 0; i < img_length; i++)
                    images[i] = {
                        src: div.find('img').eq(i).attr("src")
                    };
                $.magnificPopup.open({
                    items: images,
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
                event.preventDefault();
            });

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.course.massDestroy'), false); ?>",
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
                //order: [[ 1, 'desc' ]],
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/course/index.blade.php ENDPATH**/ ?>