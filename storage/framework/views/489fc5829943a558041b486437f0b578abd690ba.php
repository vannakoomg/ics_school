

<?php $__env->startSection('styles'); ?>

<style>
.note-editable { background-color: white !important; color: black !important; }
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Add News Notification
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="<?php echo e(route('admin.message.store'), false); ?>" >
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('Title'), false); ?></label>
                <input class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : '', false); ?>" type="text" name="txt_title" id="txt_title" value="<?php echo e(old('txt_title'), false); ?>" required>
                <?php if($errors->has('txt_title')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('txt_title'), false); ?>

                    </div>
                <?php endif; ?>

            </div>
            </div>
            <div class="col-2">
                <img src="<?php echo e(asset('images/blank.jpeg'), false); ?>" class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" style="display: none"/>
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles"><?php echo e(trans('Message'), false); ?></label>
                    
                    <textarea name="txt_body_hidden" id="txt_body_hidden" class="form-control" rows="5" required><?php echo e(old('txt_body_hidden'), false); ?></textarea>
             
                    <input type="hidden" name="save_send" value="save">
            </div>

                <div class="form-group">
                    <label class="" for="roles"><?php echo e(trans('Class'), false); ?> <span class="text-danger">(No Select, Will broadcast message to all students.)</span></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all'), false); ?></span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['kindergarten-mc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Kindergarten-MC'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['primary-mc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Primary-MC'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['secondary-mc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Secondary-MC'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['kindergarten-cc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Kindergarten-CC'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['primary-cc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Primary-CC'), false); ?></span>
                        <span class="btn btn-info btn-xs select-class" data-value="<?php echo e(json_encode($filter['secondary-cc']), false); ?>" style="border-radius: 0"><?php echo e(trans('Secondary-CC'), false); ?></span>
                    </div>
                    <select class="select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>" name="txt_class[]" id="txt_class" multiple>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id, false); ?>" <?php echo e(in_array($class->id, old('roles', [])) ? 'selected' : '', false); ?>><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('class')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('class'), false); ?>

                        </div>
                    <?php endif; ?>

                </div>
            <div class="form-group">
                <button class="btn btn-danger btn_send" data-value="save" type="submit">
                    <?php echo e(trans('global.save'), false); ?> Only
                </button>
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    <?php echo e(trans('global.save'), false); ?> & Send Notification
                </button>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>

<script>

    window.onbeforeunload = function () {
        $("input[type=button], input[type=submit]").attr("disabled", "disabled");
    };

    $(document).ready(function() {
    
    $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select-class').on("click", function(){
        var arr_selected = $(this).data('value');

        $('.select2').val(arr_selected).change();
        console.log(arr_selected);
    })

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

    $(".btn_send").click(function(){
        $('input[name="save_send"]').val($(this).data('value'));  
    });

//    $('#upload_image_form').submit(function(e) {

//      e.preventDefault();
   
//      if($('#imgupload').val()==''){
//          alert('Picture is required.');
//          return false;
//      }

//      btn_send = $('.btn_send');

//      btn_send.prop('disabled', true);

  

//      var formData = new FormData(this);

//      $.ajax({
//         type:'POST',
//         url: "<?php echo e(route('admin.message.store'), false); ?>",
//         data: formData,
//         cache:false,
//         contentType: false,
//         processData: false,
//         success: (data) => {
//             console.log(data);

//             btn_send.prop('disabled', false);
//            //this.reset();
//         //    $('#txt_body').summernote('reset');
//         //    $('#txt_class').val('');
//         //    $('#img_thumbnail').attr('src','<?php echo e(asset('images/blank.jpeg'), false); ?>');
//         if(!data.success)
//             return false;

//         if($('input[name="save_send"]').val()=='save')
//             alert('The Message has been saved.');
//         else
//             alert('The Message has been saved and sent.');

//         window.location = data.edit_link;

//         },
//         error: function(data){
//            console.log(data);
//          }
//        });
//    });


});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/notifications/create.blade.php ENDPATH**/ ?>