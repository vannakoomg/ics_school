@extends('layouts.admin')

@section('styles')
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
<style>
.note-editable { background-color: white !important; color: black !important; }
</style>


@endsection



@section('content')
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Add News Article
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" novalidate="novalidate" action="{{ route('admin.announcement.store') }}" >
            @csrf
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name">{{ trans('Title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="txt_title" id="txt_title" value="{{ old('txt_title') }}" required>
                @if($errors->has('txt_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('txt_title') }}
                    </div>
                @endif

            </div>
            </div>
            <div class="col-2">
                <img src="{{ asset('images/blank.jpeg') }}" class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" style="display:none"/>
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles">{{ trans('Content') }}</label>
                    {{-- <div class="summernote" id='txt_body'>{{ old('txt_body_hidden') }}</div> --}}
                    <textarea name="txt_body_hidden" class="summernote" data-msg="Please write something :)" id='txt_body' required>{{ old('txt_body_hidden') }}</textarea>
                    <input type="hidden" name="txt_class[]">
                    <input type="hidden" name="save_send" value="save">
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
                <button class="btn btn-danger btn_send" data-value="save" type="submit">
                    {{ trans('global.save') }} Only
                </button>
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    {{ trans('global.save') }} & Send Notification
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

    $(function () {
    
    
    var summernoteForm = $('#upload_image_form');
    var summernoteElement = $('#txt_body');
    
    var summernoteValidator = summernoteForm.validate({
        errorElement: "div",
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        ignore: ':hidden:not(.summernote),.note-editable.card-block',
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("invalid-feedback");
            console.log(element);
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.siblings("label"));
            } else if (element.hasClass("summernote")) {
                error.insertAfter(element.siblings(".note-editor"));
            } else {
                error.insertAfter(element);
            }
        }
    });

    summernoteElement.summernote({
         height:300,
        //  codemirror: { // codemirror options
        //      theme: 'monokai'
        //  },
         callbacks: {
            onChange: function (contents, $editable) {
                // Note that at this point, the value of the `textarea` is not the same as the one
                // you entered into the summernote editor, so you have to set it yourself to make
                // the validation consistent and in sync with the value.
                summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : summernoteElement.summernote('code'));
                
                // $('#txt_body_hidden').val($('#txt_body').summernote('code'));

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element(summernoteElement);
            }
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
//         url: "{{ route('admin.announcement.store') }}",
//         data: formData,
//         cache:false,
//         contentType: false,
//         processData: false,
//         success: (data) => {
           
//             btn_send.prop('disabled', false);
//            //this.reset();
//         //    $('#txt_body').summernote('reset');
//         //    $('#txt_class').val('');
//         //    $('#img_thumbnail').attr('src','{{ asset('images/blank.jpeg') }}');
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
@endsection
