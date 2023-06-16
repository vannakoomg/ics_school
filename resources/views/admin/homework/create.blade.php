@extends('layouts.admin')

@section('styles')
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
<style>
.note-editable { background-color: white !important; color: black !important; }
</style>


@endsection



@section('content')

<div class="alert alert-success" style="display:none">
    {{ Session::get('success') }}
</div>

    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Add New Assignment
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="{{ route('admin.homework.store') }}" >
            @csrf
            
            <div class="row">
                <div class="col">
                    <div class="form-group">

                    <label class="required">Class</label>
                    <select name='classes' id="classes" class="custom-select select2">
                        @foreach($classes as $id => $class)
                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->campus }})</option>
                        @endforeach
                    </select>

                    </div>
                </div>    
                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Language</label>
                        <select name='language' id='language' class="custom-select select2">
                            @foreach($languages as $id => $language)
                                <option value="{{ $language }}">{{ $language }}</option>
                            @endforeach
                        </select>
    
                        </div>
                    </div>    

                    <div class="col">
                        <div class="form-group">
    
                        <label class="required">Course</label>
                        <select name='course' id='course' required="true" class="custom-select select2">
                            @foreach($courses as $id => $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
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
                                @foreach($terms as $id => $term)
                                    <option value="{{ $term }}">{{ $term }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>   

            </div>

            <div class="form-group contain">
                    <label class="" for="roles">{{ trans('Instruction') }}</label>
                   
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
                {{-- <div class="form-group">
                    <label class="" for="roles">{{ trans('Class') }} <span class="text-danger">(Blank will send public message)</span></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="txt_class[]" id="txt_class" multiple>
                        @foreach($classes as $id => $class)
                            <option value="{{ $class->id }}" {{ in_array($class->id, old('roles', [])) ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('class'))
                        <div class="invalid-feedback">
                            {{ $errors->first('class') }}
                        </div>
                    @endif

                </div> --}}
            <div class="form-group">
                <button class="btn btn-primary btn_send" data-value="save" type="submit">
                    {{ trans('global.save') }}
                </button>
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    {{ trans('Publish') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>

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
        url: "{{ route('admin.homework.ajaxupload') }}",
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
        url: "{{ route('admin.course.getlist') }}",
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
@endsection
