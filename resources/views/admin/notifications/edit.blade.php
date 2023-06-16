@extends('layouts.admin')

@section('styles')
<style>
.note-editable { background-color: white !important; color: black !important; }
</style>
@endsection



@section('content')
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Edit Notification
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="{{ route('admin.message.update',$message->id) }}" >
            @csrf
            @method('PUT')
         
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name">{{ trans('Title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="txt_title" id="txt_title" value="{{ old('txt_title', $message->title) }}" required>
                @if($errors->has('txt_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('txt_title') }}
                    </div>
                @endif

            </div>
            </div>
            <div class="col-2">
                {{-- <img src="{{ asset('images/blank.jpeg') }}" class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px"> --}}
                <img src="{{ asset('storage/image/' . $message->thumbnail) }}" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="{{ asset('storage/image' . $message->thumbnai) }}" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" value=""  style="display:none"/>
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles">{{ trans('Message') }}</label>
                    <textarea name="txt_body_hidden" id="txt_body_hidden" class="form-control" rows="5" required>{{ old('txt_body_hidden',$message->body ?? '') }}</textarea>
                    
                    <input type="hidden" name="save_send" value="save">
            </div>

                <div class="form-group">
                    <label class="" for="roles">{{ trans('Class') }} <span class="text-danger">(No Select, Will broadcast message to all students.)</span></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['kindergarten-mc']) }}" style="border-radius: 0">{{ trans('Kindergarten-MC') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['primary-mc']) }}" style="border-radius: 0">{{ trans('Primary-MC') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['secondary-mc']) }}" style="border-radius: 0">{{ trans('Secondary-MC') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['kindergarten-cc']) }}" style="border-radius: 0">{{ trans('Kindergarten-CC') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['primary-cc']) }}" style="border-radius: 0">{{ trans('Primary-CC') }}</span>
                        <span class="btn btn-info btn-xs select-class" data-value="{{ json_encode($filter['secondary-cc']) }}" style="border-radius: 0">{{ trans('Secondary-CC') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="txt_class[]" id="txt_class" multiple>
                        @foreach($classes as $id => $class)
                            <option value="{{ $class->id }}" {{ in_array($class->id, old('txt_class',[])) || $message->classes->contains($class->id) ? 'selected' : '' }}>{{ $class->name }}-{{ $class->campus }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('class'))
                        <div class="invalid-feedback">
                            {{ $errors->first('class') }}
                        </div>
                    @endif

                </div>
            <div class="form-group">
                <button class="btn btn-danger btn_send" data-value="save" type="submit">
                    {{ trans('global.save') }} Only
                </button>
                <button class="btn btn-success btn_send" data-value="send" type="submit" {{ ($message->send==1)?'disabled':'' }}>
                    {{ trans('global.save') }} & Send Notification
                </button>
            </div>
        </form>
    </div>

@endsection


@section('scripts')
@parent
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
    //         url:       "{{ route('admin.message.update',$message->id) }}",         // override for form's 'action' attribute
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

    //         window.location = "{{ route('admin.message.edit',$message->id) }}";
    //     }


    // }


});
</script>
@endsection