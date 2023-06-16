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
                    View News
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)" >
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('Title'), false); ?></label>
                <span class="input-group-text">
                    <?php echo e($announcement->title, false); ?>

                </span>
            </div>
            </div>
            <div class="col-2">
                <div class="xzoom-thumbs">
                    <img src="<?php echo e(asset('storage/image/' . $announcement->thumbnail), false); ?>" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="<?php echo e(asset('storage/image' . $announcement->thumbnai), false); ?>" width="150px" height="150px">
                </div> 
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles"><?php echo e(trans('Content'), false); ?></label>
                    <div class="card card-body">
            
                        <?php echo $announcement->body; ?>

               
                    </div>
            </div>

            <div class="form-group">
                <a class="btn btn-secondary" href="<?php echo e(route('admin.announcement.index'), false); ?>">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/hdd/www/school/resources/views/admin/announcement/show.blade.php ENDPATH**/ ?>