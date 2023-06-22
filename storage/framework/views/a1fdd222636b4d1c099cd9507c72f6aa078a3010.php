

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('summernote/summernote.min.css'), false); ?>" rel="stylesheet">
<style>
.note-editable { background-color: white !important; color: black !important; }
</style>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<div class="alert alert-success" style="display:none">
    <?php echo e(Session::get('success'), false); ?>

</div>

    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Add New Assignment
                </div>
   <?php
    $roles=[];

   ?>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="<?php echo e(route('admin.homework.store'), false); ?>" >
            <?php echo csrf_field(); ?>
            
            <div class="row">
                <div class="col">
                    <div class="form-group">

                    <label class="required">Class</label>
                    <select name='classes' id="classes" class="custom-select select2">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id, false); ?>"><?php echo e($class->name, false); ?> (<?php echo e($class->campus, false); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    </div>
                </div>    
                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Language</label>
                        <select name='language' id='language' class="custom-select select2">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($language, false); ?>"><?php echo e($language, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
    
                        </div>
                    </div>    

                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Course</label>
                        <select name='course' id='course' required="true" class="custom-select select2">
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course->id, false); ?>"><?php echo e($course->name, false); ?></option>
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
                            <input name="name" type="text" required="true" value="" placeholder="Title..." maxlength="100" class="form-control"/>
                        </div>
                    </div>
                </div>    

                <div class="col">
                    <div class="form-group">
                       
                            <label class="col-form-label required">Marks</label>
                        

                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <input name="marks" type="number" min="1" max="100" value="0" class="form-control"/>
                            </div>
                            <div class="col-auto">
                                <label class="form-text"> Points</label>
                            </div>
                        </div>
                    </div>
                </div>    

                <div class="col">
                    <div class="form-group">

                    <label class="required">Due Date</label>
                   <input type="text" class="form-control" name="due_date"/>

                    </div>
                </div>  

          

                <div class="col-3">
                    <div class="form-group">
                        <label class="required">Term</label>
                        <div class="">
                            <select name='term' id='term' class="custom-select">
                                <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($term, false); ?>"><?php echo e($term, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>   

            </div>

            <div class="form-group contain">
                    <label class="" for="roles"><?php echo e(trans('Instruction'), false); ?></label>
                   
                    <textarea name="homework" class="summernote" data-msg="Please write something :)" id='homework'></textarea>
              
                    <input type="hidden" name="save_send" value="save">
            </div>
            <div class="form-group">
                <label class="">Attachments</label>
                <div class="dropzone" id="dropzone">
                    <div class="dropzone-previews"></div>
                    <div class="dz-default dz-message"><h4>Drop files here or click to upload</h4></div>
                </div>
            </div>
                
            <div class="form-group">
                <button class="btn btn-primary btn_send" data-value="save" type="submit">
                    <?php echo e(trans('global.save'), false); ?>

                </button>
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    <?php echo e(trans('Publish'), false); ?>

                </button>
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
    
    let myDropzone=$('div#dropzone').dropzone({
    init: function(){
    thisDropzone = this;
       
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

                        if(thisDropzone.files.length>0)
                            thisDropzone.processQueue();
                        else {

                            var d = $("input[name='due_date']").val();
                            $('#upload_image_form')[0].reset();
                            $("input[name='due_date']").val(d);
                            $("select.select2").trigger("change");
                            $('#homework').summernote('reset');

                            $(".alert-success").css("display", "block");
                            $(".alert-success").html("<p>The Homework has been Added.</p>");
                            $(".alert-success").delay(5000).slideUp(300);

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
            var d = $("input[name='due_date']").val();
            $('#upload_image_form')[0].reset();
            $("input[name='due_date']").val(d);
            $("select.select2").trigger("change");
            $('#homework').summernote('reset');

            $('.dropzone-previews').empty();

            $(".alert-success").css("display", "block");
            $(".alert-success").html("<p>The Homework has been Added.</p>");
            $(".alert-success").delay(5000).slideUp(300);
        });



    },  
    accept: function(file, done){
        if(file.name.length>50){
            done('Filename exceeds 50 characters!');
        }else { done(); }
    },
        uploadMultiple:true,
        // acceptedFiles: '.pdf,.jpg,.png,.gif,.docx,.doc,.xls,.xlsx,.pptx,.ppt',
        acceptedFiles: "application/msword, application/vnd.ms-excel, application/pdf, image/*, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, image/*",
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
        
    //     homework:{
    //         //required:true,
    //         normalizer: function (value) {
    //             //Trim the value of element for whitespaces
            
    //             return $.trim(value.replace(/<\/?[^>]+(>|$)/g, ""));
    //         }
    //     }
    // },
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
                // Note that at this point, the value of the `textarea` is not the same as the one
                // you entered into the summernote editor, so you have to set it yourself to make
                // the validation consistent and in sync with the value.
                summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : contents);
                
                // $('#txt_body_hidden').val($('#txt_body').summernote('code'));

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                //summernoteValidator.element(summernoteElement);
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

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/homework/create.blade.php ENDPATH**/ ?>