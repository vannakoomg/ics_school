<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/xzoom.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('css/magnific-popup.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('summernote/summernote.min.css'), false); ?>" rel="stylesheet">
    <style>
        .note-editable { background-color: white !important; color: black !important; }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    View Feedback
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="<?php echo e(route("admin.feedback.update",$feedback->id), false); ?>" >
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <div class="row">
                
            <div class="col-2">
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('Date'), false); ?></label>
                    <span class="input-group-text">
                        <?php echo e($feedback->date, false); ?>

                    </span>
                </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="required" for="name"><?php echo e(trans('Posted By'), false); ?></label>
                        <span class="input-group-text">
                            <?php echo e($feedback->student->name, false); ?>

                        </span>
                    </div>
                    </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="" for="name"><?php echo e(trans('Category'), false); ?></label>
                        <span class="input-group-text">
                            <?php echo e($feedback->category, false); ?>

                        </span>
                    </div>
                    </div>
                <div class="col-4">
                        <div class="form-group">
                            <label class="" for="name"><?php echo e(trans('Student Class'), false); ?></label>
                            <span class="input-group-text">
                                <?php echo e($feedback->student->class->name ?? '', false); ?>-<?php echo e($feedback->student->class->campus ?? '', false); ?>

                            </span>
                        </div>
                        </div>    
            <div class="col-2">
                <div class="xzoom-thumbs">
                    <?php if(!empty($feedback->image)): ?>
                        <img src="<?php echo e(asset('storage/image/' . $feedback->image), false); ?>" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="<?php echo e(asset('storage/image' . $feedback->thumbnai), false); ?>" width="150px" height="150px">
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/no-image.png'), false); ?>" class="btn btn-outline-primary" width="150px" height="150px">
                    <?php endif; ?>
                </div> 
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles"><?php echo e(trans('Parents Question'), false); ?></label>
                    <div class="card card-body">
            
                        <?php echo $feedback->question; ?>

               
                    </div>
            </div>
            <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="" for="name"><?php echo e(trans('Reply By'), false); ?></label>
                    <span class="input-group-text">
                        <?php echo e($feedback->replyer ?? Auth::user()->name, false); ?>

                    </span>
                </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="" for="name"><?php echo e(trans('Reply At'), false); ?></label>
                        <span class="input-group-text">
                            <?php echo e($feedback->replied_at ?? date("d/m/Y h:i A"), false); ?>

                        </span>
                    </div>
                    </div>   

            </div>    
            <div class="form-group contain">
                <label class="required" for="roles"><?php echo e(trans('Reply Message'), false); ?></label>
                <div class="card card-body">
                    <?php if($feedback->reply=='1'): ?>
                        <?php echo $feedback->answer; ?>

                    <?php else: ?>
                        <textarea name="answer" required><?php echo e($feedback->answer ?? '', false); ?></textarea>
                    <?php endif; ?>
           
                </div>
        </div>
            <div class="form-group">
                <a class="btn btn-secondary" href="<?php echo e(route('admin.feedback.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>

                <button type="submit" class="btn btn-primary pull-right" <?php echo e(($feedback->reply==1)?'disabled':'', false); ?>>
                    <?php echo e(trans('Reply & Send Notification'), false); ?>

                </button>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script src="<?php echo e(asset('js/xzoom.min.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/magnific-popup.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/jquery.hammer.min.js'), false); ?>"></script>

<script>
$(document).ready(function() {
        
        // $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});
         
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
     });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/wwww/school/resources/views/admin/feedback/show.blade.php ENDPATH**/ ?>