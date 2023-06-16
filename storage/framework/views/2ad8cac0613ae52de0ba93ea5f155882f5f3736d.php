<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('summernote/summernote.min.css'), false); ?>" rel="stylesheet">
<style>
.note-editable { background-color: white !important; color: black !important; }
.dropzone .dz-preview .dz-error-message {
    top: 150px!important;
}
</style>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Edit Assignment
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="<?php echo e(route('admin.homework.update',[$homework->id]), false); ?>" >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col">
                    <div class="form-group">

                    <label class="required">Class</label>
                    <select name='classes' id="classes" class="custom-select select2">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id, false); ?>" <?php echo e(($class->id==old("classes",$homework->class_id)) ? "selected":"", false); ?>><?php echo e($class->name, false); ?> (<?php echo e($class->campus, false); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    </div>
                </div>    
                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Language</label>
                        <select name='language' id='language' class="custom-select select2">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($language, false); ?>" <?php echo e(($language==old("language",$homework->language)) ? "selected":"", false); ?>><?php echo e($language, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
    
                        </div>
                    </div>    

                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Course</label>
                        <select name='course' id='course' required="true" class="custom-select select2">
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course->id, false); ?>" <?php echo e(($course->id==old("course",$homework->course_id)) ? "selected":"", false); ?>><?php echo e($course->name, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
    
                        </div>
                    </div>  

            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="col-form-label required">Title</label>
                        <div class="align-items-center">
                            <input name="name" type="text" required="true" value="<?php echo e(old('name',$homework->name), false); ?>"  placeholder="Title..." maxlength="100" class="form-control"/>
                        </div>
                    </div>
                </div>    

                <div class="col">

                   
                    <div class="form-group">
                       
                            <label class="col-form-label required">Marks</label>
                        

                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <input name="marks" type="number" min="1" max="100" value="<?php echo e(old('marks',$homework->marks), false); ?>" class="form-control"/>
                            </div>
                            <div class="col-auto">
                                <label class="form-text"> Points </label>
                            </div>
                        </div>
                    </div>
                </div>    

                <div class="col">
                    <div class="form-group">

                    <label class="required">Due Date</label>
                   <input type="text" class="form-control" value="<?php echo e(old('due_date',$homework->due_date->format('d/m/Y H:i:s')), false); ?>" name="due_date"/>

                    </div>
                </div>  

                <div class="col">
                    <div class="form-group">

                    <label class="required">Term</label>
                    <select name='term' id='term' class="custom-select">
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($term, false); ?>" <?php echo e(($term==old("term",$homework->term)) ? "selected":"", false); ?>><?php echo e($term, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    </div>
                </div>  


            </div>

            <div class="form-group contain">
                    <label class="" for="roles"><?php echo e(trans('Instruction'), false); ?></label>
                   
                    <textarea name="homework" maxLen="true" class="summernote" data-msg="Please write something :)"  id='homework'><?php echo e(old('homework',$homework->description), false); ?></textarea>
              
                    <input type="hidden" name="save_send" value="save">
                   
            </div>
            <div class="form-group">
                <input name="deleted_files" type="hidden" value=''/>
                <label class="">Attachments</label>
                <div class="dropzone" id="dropzone">
                    <div class="dropzone-previews"></div>
                    
                </div>

                
            </div>
          
                
            <div class="form-group">
                <button class="btn btn-primary btn_send" data-value="save" type="submit">
                    <?php echo e(trans('global.save'), false); ?>

                </button>

                <a href="<?php echo e(route('admin.homework.index'), false); ?>" class="btn btn-secondary float-right btn_send">
                    <?php echo e(trans('global.back_to_list'), false); ?>

                </a>

                <?php if($homework->submitted===0): ?>
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    <?php echo e(trans('Publish'), false); ?>

                </button>
                <?php endif; ?>
                <?php if($homework->submitted===1): ?>
                <button class="btn btn-success btn_send" data-value="resend" type="submit">
                    <?php echo e(trans('Republish'), false); ?>

                </button>
                <?php endif; ?>
              
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script src="<?php echo e(asset('summernote/summernote-bs4.min.js'), false); ?>"></script>

<script>

    window.onbeforeunload = function () {
        $("input[type=button], input[type=submit]").attr("disabled", "disabled");
    };

    Dropzone.autoDiscover = false;

    $(function () {
    
        var trid;
    let token = $('meta[name="csrf-token"]').attr('content');
    var array = [];
    var uploaded = false;
    let myDropzone=$('div#dropzone').dropzone({
    init: function(){
    thisDropzone = this;
       
            <?php $__currentLoopData = $homework->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  var mockFile = { trid: "<?php echo e($attachment->id, false); ?>", name: "<?php echo e($attachment->filename, false); ?>", size: <?php echo e($attachment->filesize, false); ?> ,status: Dropzone.QUEUED, accepted: true, upload: {} };
                  thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                  thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "<?php echo e($attachment->link, false); ?>");

                 // console.log("<?php echo e($attachment->link, false); ?>");
                
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
       $('#upload_image_form').submit(function(event) {
            event.preventDefault();
            uploaded = false;
            for(i=0;i<thisDropzone.files.length;i++){
                if(thisDropzone.files[i].status=='error')
                    uploaded=true;
            }
                
           
            if(uploaded){
                alert('Invalid File Upload. Please verify files.');
                return false;
            }

            $(".btn_send").attr("disabled", true);
            URL = $(this).attr('action');
            frmData = $(this).serialize();
            $.ajax({
                type:'POST',
                url:URL,
                data:frmData,
                success: function(result){

                    if(result.status=='success'){
                        $(".btn_send").attr("disabled", false);
                        trid=result.trid;
                        
                        if(thisDropzone.files.length>0){
                            
                            thisDropzone.processQueue();
                        }else {

                           window.location = '<?php echo e(route("admin.homework.edit",[$homework->id]), false); ?>';
                            // $('#upload_image_form')[0].reset();
                            // $('#homework').summernote('reset');

                            // $(".alert-success").css("display", "block");
                            // if($('input[name="save_send"]').val()=='save')
                            //     $(".alert-success").append("<p>The Homework has been updated.</p>");
                            // else if($('input[name="save_send"]').val()=='send')
                            //     $(".alert-success").append("<p>The Homework has been updated and published.</p>");
                            // else if($('input[name="save_send"]').val()=='resend')
                            //     $(".alert-success").append("<p>The Homework has been updated and re-published.</p>");    

                            //  $(".alert-success").delay(5000).slideUp(300);

                        }    
                    }else{
                        console.log('Error');
                    }
                }

            });

       });

       this.on('sending', function(file, xhr, formData) {
            formData.append("trid", trid);
        });

        this.on('success', function(file, response) {
            console.log(response);

            window.location = '<?php echo e(route("admin.homework.edit",[$homework->id]), false); ?>';

            // $(".alert-success").css("display", "block");
            // $(".alert-success").append("<p>The Homework has been Added.</p>");
            // $(".alert-success").delay(5000).slideUp(300);
        });



    },  
    removedfile: function(file) {
    x = confirm('Do you want to delete ' + file.name + '?');
    if(!x)  return false;
     
    console.log(file);
    array.push(file.trid);

    var json = JSON.stringify(array);

    $('input[name="deleted_files"]').val(array);
    
    file.previewElement.remove();

    },
    accept: function(file, done){
        if(file.name.length>50){
            done('Filename exceeds 50 characters!');
        }else { 
            
            done(); 
        }

    },
        // acceptedFiles: '.pdf,.jpg,.png,.gif,.docx,.doc,.xls,.xlsx,.pptx,.ppt',
        acceptedFiles: "application/msword, application/vnd.ms-excel, application/pdf, image/*, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, image/*",
        uploadMultiple:true,
        previewsContainer: '.dropzone-previews',
        paramName:'file',
        url: "<?php echo e(route('admin.homework.ajaxupload'), false); ?>",
        addRemoveLinks: true,
        maxFilesize: 5,
        autoProcessQueue:false,
        dictCancelUpload: "Cancel",
        //dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
        dictResponseError: 'Error uploading file!',
        params:{
            _token: token
        }

    });


    var summernoteForm = $('#upload_image_form');
    var summernoteElement = $('#homework');
    
    // var summernoteValidator = summernoteForm.validate({
    //     errorElement: "div",
    //     errorClass: 'is-invalid',
    //     validClass: 'is-valid',
    //     ignore: ':hidden:not(.summernote),.note-editable.card-block',
    //     rules:{
        
    //         homework:{
    //             required:true,
    //             normalizer: function (value) {
    //                 //Trim the value of element for whitespaces
                
    //                 return $.trim(value.replace(/<\/?[^>]+(>|$)/g, ""));
    //             }
    //         }
    //     },
    //     errorPlacement: function (error, element) {
    //         // Add the `help-block` class to the error element
    //         error.addClass("invalid-feedback");
    //         console.log(element);
    //         if (element.prop("type") === "checkbox") {
    //             error.insertAfter(element.siblings("label"));
    //         } else if (element.hasClass("summernote")) {
    //             error.insertAfter(element.siblings(".note-editor"));
    //         } else {
    //             error.insertAfter(element);
    //         }
    //     }
    // });

    summernoteElement.summernote({
         height:250,
        //  codemirror: { // codemirror options
        //      theme: 'monokai'
        //  },
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
         callbacks: {
            onChange: function (contents, $editable) {
                contents = contents.replace(/<\/?[^>]+(>|$)/g, "");
                // Note that at this point, the value of the `textarea` is not the same as the one
                // you entered into the summernote editor, so you have to set it yourself to make
                // the validation consistent and in sync with the value.
                summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : contents);
                
                // $('#txt_body_hidden').val($('#txt_body').summernote('code'));

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                // summernoteValidator.element(summernoteElement);
            }
        }
     });
    
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });

     var dateNow = new Date();

    $('input[name="due_date"]').datetimepicker({
        format: 'DD/MM/YYYY HH:mm:ss',
        locale: 'en',
        sideBySide: true,
        defaultDate: dateNow,
        icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        }
    });

    $('#classes,#language').change(function(){

    var formData = {'class_id': $('#classes').val(),'language':$('#language').val()};
    $.ajax({
        type:'POST',
        url: "<?php echo e(route('admin.course.getlist'), false); ?>",
        data: formData,
        cache:false,
        // contentType: false,
        // processData: false,
        success: (data) => {
            $('#course').empty();
            $.each(data, function(i,d){
                $('#course').append($('<option></option',{'value':d.id}).text(d.name));
            });
            //console.log(data);
        }
        

    });

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

//      $('#txt_body_hidden').val($('#txt_body').summernote('code'));

//      var formData = new FormData(this);

//      $.ajax({
//         type:'POST',
//         url: "<?php echo e(route('admin.announcement.store'), false); ?>",
//         data: formData,
//         cache:false,
//         contentType: false,
//         processData: false,
//         success: (data) => {
           
//             btn_send.prop('disabled', false);
//            //this.reset();
//         //    $('#txt_body').summernote('reset');
//         //    $('#txt_class').val('');
//         //    $('#img_thumbnail').attr('src','<?php echo e(asset('images/blank.jpeg'), false); ?>');
//            alert('The Announcement has been added.');
          
//            window.location = data.edit_link ;
//         },
//         error: function(data){
//            console.log(data);
//          }
//        });
//    });


});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/admin/homework/edit.blade.php ENDPATH**/ ?>