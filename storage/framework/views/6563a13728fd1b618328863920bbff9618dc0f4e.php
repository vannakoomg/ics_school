

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/xzoom.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('css/magnific-popup.css'), false); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
         
        </div>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-header">
<form method="get" action="<?php echo e(route('admin.feedback.index'), false); ?>" id="form1">
        <span>
        Parent Feedback List
        </span>

        <span class="float-right form-check form-switch">
            <input type="checkbox" name="chk_show" class="form-check-input" <?php echo e(request()->chk_show=="on"?"checked":"", false); ?>>
              <label class="form-check-label" for="flexCheckDefault">
                Show Replied
              </label>
              
            </span>
</form>     
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('Date'), false); ?>

                        </th>
                        <th>
                            Attachment
                        </th>
                        <th class="text-nowrap">
                            Posted By
                        </th>
                        <th width="100px">
                            Student Class
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            <?php echo e(trans('Question'), false); ?>

                        </th>
                        
                        
                        <th>
                            Replied
                        </th>
                        <th class="text-nowrap">
                            <?php echo e(trans('Reply by'), false); ?>

                        </th>
                        <th class="text-nowrap">
                            <?php echo e(trans('Reply At'), false); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                   <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <tr>
                        <td> </td>
                        <td>
                            <?php echo e($feedback->date, false); ?>

                        <br/>
                           <span class="text-muted"><?php echo e($feedback->time, false); ?></span> </td>
                        <td>
                            <div class="xzoom-thumbs text-left">
                                <?php if(!empty($feedback->image)): ?>
                                    <img src="<?php echo e(asset('storage/image/' . $feedback->image), false); ?>" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="<?php echo e(asset('storage/image' . $feedback->thumbnai), false); ?>" style="height: 100px !important">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/no-image.png'), false); ?>" class="btn btn-outline-primary"  height="100px">
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?php echo e($feedback->student->name, false); ?></td>
                        <td>
                            <?php echo e($feedback->student->class->name ?? '', false); ?>-<?php echo e($feedback->student->class->campus ?? '', false); ?>

                        </td>
                        <td><?php echo e($feedback->category ?? '', false); ?></td>
                        <td><?php echo e($feedback->question, false); ?></td>
                        <td class="text-center">
                            <?php echo e(($feedback->reply==1)?'Yes':'No', false); ?>

                        </td>
                       
                        <td>
                        
                        <?php echo e($feedback->replied_by, false); ?>

                        </td>
                        
                        <td>
                        
                            <?php echo e($feedback->replied_at, false); ?>

                            </td>
                        
                        <td>
                          
                                    <a class="btn btn-xs btn-primary text-nowrap" href="<?php echo e(route('admin.feedback.show', $feedback->id), false); ?>">
                                        <?php echo e(trans('global.view'), false); ?> & Reply
                                    </a> 
                           
                                  

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
    $(function () {

    $('input[type="checkbox"]').on("change", function(){
        $('#form1').submit();
    });  

    $('.xzoom-gallery').bind('click', function(event) {
                var div= $(this).parents('.xzoom-thumbs');
                // var xzoom = $(this).data('xzoom');
                // xzoom.closezoom();
                // var gallery = xzoom.gallery().cgallery;
                // var i, images = new Array();
                // for (i in gallery) {
                //     images[i] = {src: gallery[i]};
                // }
                images = new Array();

                var img_length = div.find('img').length;
                for(i=0;i<img_length;i++)
                images[i]= {src: div.find('img').eq(i).attr("src")};
                $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                event.preventDefault();
    });

  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/feedback/index.blade.php ENDPATH**/ ?>