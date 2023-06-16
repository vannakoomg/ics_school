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
                    Edit Notification
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="<?php echo e(route('admin.message.update',$message->id), false); ?>" >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
         
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('Title'), false); ?></label>
                <input class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : '', false); ?>" type="text" name="txt_title" id="txt_title" value="<?php echo e(old('txt_title', $message->title), false); ?>" required>
                <?php if($errors->has('txt_title')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('txt_title'), false); ?>

                    </div>
                <?php endif; ?>

            </div>
            </div>
            <div class="col-2">
                
                <img src="<?php echo e(asset('storage/image/' . $message->thumbnail), false); ?>" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="<?php echo e(asset('storage/image' . $message->thumbnai), false); ?>" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" value=""  style="display:none"/>
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles"><?php echo e(trans('Message'), false); ?></label>
                    <textarea name="txt_body_hidden" id="txt_body_hidden" class="form-control" rows="5" required><?php echo e(old('txt_body_hidden',$message->body ?? ''), false); ?></textarea>
                    
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
                    <select class="form-control select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>" name="txt_class[]" id="txt_class" multiple>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id, false); ?>" <?php echo e(in_array($class->id, old('txt_class',[])) || $message->classes->contains($class->id) ? 'selected' : '', false); ?>><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
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
                <button class="btn btn-success btn_send" data-value="send" type="submit" <?php echo e(($message->send==1)?'disabled':'', false); ?>>
                    <?php echo e(trans('global.save'), false); ?> & Send Notification
                </button>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script>

    window.onbeforeunload = function () {
        $("input[type=button], input[type=submit]").attr("disabled", "disabled");
    };

    $(document).ready(function() {

    // function escapeHtml(str) {
    //     return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    // }

    // $.ajaxSetup({
    //    headers: {
    //        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });


    // $('#txt_body').html();


   // $('#txt_body').summernote('code', text);

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

    // var options = {
    //         //target:        '#output2',   // target element(s) to be updated with server response
    //         beforeSubmit:  showRequest,  // pre-submit callback
    //         success:       showResponse , // post-submit callback
    //         error:   errorResponse,
    //         // other available options:
    //         url:       "<?php echo e(route('admin.message.update',$message->id), false); ?>",         // override for form's 'action' attribute
    //         type:      'POST'        // 'get' or 'post', override for form's 'method' attribute
    //         //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
    //         //clearForm: true        // clear all form fields after successful submit
    //         //resetForm: true        // reset the form after successful submit

    //         // $.ajax options can be used here too, for example:
    //         //timeout:   3000
    //     };

    // $('#upload_image_form').ajaxForm(function() {

    //    // $('#txt_body_hidden').val($('#txt_body').summernote('code'));

    //     $('#upload_image_form').ajaxSubmit(options);
    //     return false;

    // });

    // $(".btn_send").click(function(){
    //     $('input[name="save_send"]').val($(this).data('value'));  
    // });

    // function showRequest(formData, jqForm, options) {
       
    //     $('.btn_send').prop('disabled', true);
    //     // formData is an array; here we use $.param to convert it to a string to display it
    //     // but the form plugin does this for you automatically when it submits the data
    //     var queryString = $.param(formData);
        
    //     // jqForm is a jQuery object encapsulating the form element.  To access the
    //     // DOM element for the form do this:
    //     var formElement = jqForm[0];

    //     // here we could return false to prevent the form from being submitted;
    //     // returning anything other than false will allow the form submit to continue
    //     return true;
    // }

    // function errorResponse(responseText, statusText, xhr, $form)  {
      
    //     if(statusText=='error')
    //         alert('Error Updated.' + responseText);
    // }

    // function showResponse(responseText, statusText, xhr, $form)  {
    //     // if($('input[name="save_send"]').val()=='send')
    //     //     $('.btn_send').eq(0).prop('disabled', false);
    //     // else
    //     //    $('.btn_send').prop('disabled', false);
    //     // for normal html responses, the first argument to the success callback
    //     // is the XMLHttpRequest object's responseText property

    //     // if the ajaxSubmit method was passed an Options Object with the dataType
    //     // property set to 'xml' then the first argument to the success callback
    //     // is the XMLHttpRequest object's responseXML property

    //     // if the ajaxSubmit method was passed an Options Object with the dataType
    //     // property set to 'json' then the first argument to the success callback
    //     // is the json data object returned by the server
        
    

    //     if(responseText.success==false)
    //         alert('Error');
    //     else{
    //         alert('The Message has been updated.');

    //         window.location = "<?php echo e(route('admin.message.edit',$message->id), false); ?>";
    //     }


    // }


});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/admin/notifications/edit.blade.php ENDPATH**/ ?>