<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('summernote/summernote.min.css')); ?>" rel="stylesheet">
// <?php echo $__env->make('popper::assets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('summernote/summernote.min.js')); ?>"></script>
<script>
    $(document).ready(function() {

    $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#txt_body').summernote({
         height:300,
         codemirror: { // codemirror options
             theme: 'monokai'
         }
     });

    $('#img_thumbnail').click(function(){
        $('#imgupload').trigger('click');
    });

    $('#imgupload').change(function(e){
       var filename = e.target.files[0].name;
       var reader = new FileReader();

     reader.onload = function(e) {
        // get loaded data and render thumbnail.
        $('#img_thumbnail').attr('src',e.target.result);
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);

    });


   $('#upload_image_form').submit(function(e) {

     e.preventDefault();

     $('#txt_body_hidden').val($('#txt_body').summernote('code'));

     var formData = new FormData(this);

     $.ajax({
        type:'POST',
        url: "<?php echo e(route('admin.announcement.create')); ?>",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
           this.reset();
           $('#txt_body').summernote('reset');
           $('#txt_class').val('');
           $('#img_thumbnail').attr('src','<?php echo e(asset('images/blank.jpeg')); ?>');
           alert('The Announcement has been added.');
        },
        error: function(data){
           console.log(data);
         }
       });
   });


});


</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Announcement
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
                <label class="required" for="name"><?php echo e(trans('Title')); ?></label>
                <input class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : ''); ?>" type="text" name="txt_title" id="txt_title" value="<?php echo e(old('title', '')); ?>" required>
                <?php if($errors->has('txt_title')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('txt_title')); ?>

                    </div>
                <?php endif; ?>

            </div>
            </div>
            <div class="col-2">
                <img src="<?php echo e(asset('images/blank.jpeg')); ?>" class="img-thumbnail" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" style="display:none"/>
            </div>
            </div>
            <div class="form-group">
                    <label class="required" for="roles"><?php echo e(trans('Body')); ?></label>
                    <div class="summernote" id='txt_body'></div>
                    <input type="hidden" name="txt_body_hidden" id="txt_body_hidden">
            </div>

                <div class="form-group">
                    <label class="" for="roles"><?php echo e(trans('Class')); ?> <span class="text-danger">(Blank will send public message)</span></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all')); ?></span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all')); ?></span>
                    </div>
                    <select class="form-control select2 <?php echo e($errors->has('class') ? 'is-invalid' : ''); ?>" name="txt_class[]" id="txt_class" multiple>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id); ?>" <?php echo e(in_array($class->id, old('roles', [])) ? 'selected' : ''); ?>><?php echo e($class->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('class')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('class')); ?>

                        </div>
                    <?php endif; ?>

                </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    <?php echo e(trans('global.save')); ?>

                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/announcement.blade.php ENDPATH**/ ?>