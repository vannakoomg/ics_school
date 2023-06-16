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
                    Add News Notification
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="{{ route('admin.message.store') }}" >
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
                <input type="file" id="imgupload" name="imgupload" style="display: none"/>
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles">{{ trans('Message') }}</label>
                    
                    <textarea name="txt_body_hidden" id="txt_body_hidden" class="form-control" rows="5" required>{{ old('txt_body_hidden') }}</textarea>
             
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
                    <select class="select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="txt_class[]" id="txt_class" multiple>
                        @foreach($classes as $id => $class)
                            <option value="{{ $class->id }}" {{ in_array($class->id, old('roles', [])) ? 'selected' : '' }}>{{ $class->name }}-{{ $class->campus }}</option>
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
                <button class="btn btn-success btn_send" data-value="send" type="submit">
                    {{ trans('global.save') }} & Send Notification
                </button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
@parent

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
//         url: "{{ route('admin.message.store') }}",
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
//         //    $('#img_thumbnail').attr('src','{{ asset('images/blank.jpeg') }}');
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
@endsection
