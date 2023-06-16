@extends('layouts.admin')


@section('styles')
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
// @include('popper::assets')
@endsection

@section('scripts')
<script src="{{ asset('summernote/summernote.min.js') }}"></script>
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
        url: "{{ route('admin.announcement.create') }}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
           this.reset();
           $('#txt_body').summernote('reset');
           $('#txt_class').val('');
           $('#img_thumbnail').attr('src','{{ asset('images/blank.jpeg') }}');
           alert('The Announcement has been added.');
        },
        error: function(data){
           console.log(data);
         }
       });
   });


});


</script>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
                <div class="card-header">
                    Announcement
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)" >
            @csrf
            <div class="row">
                <div class="col-10">
            <div class="form-group">
                <label class="required" for="name">{{ trans('Title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="txt_title" id="txt_title" value="{{ old('title', '') }}" required>
                @if($errors->has('txt_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('txt_title') }}
                    </div>
                @endif

            </div>
            </div>
            <div class="col-2">
                <img src="{{ asset('images/blank.jpeg') }}" class="img-thumbnail" id="img_thumbnail" alt="select thumbnail" width="150px" height="150px">
                <input type="file" id="imgupload" name="imgupload" style="display:none"/>
            </div>
            </div>
            <div class="form-group">
                    <label class="required" for="roles">{{ trans('Body') }}</label>
                    <div class="summernote" id='txt_body'></div>
                    <input type="hidden" name="txt_body_hidden" id="txt_body_hidden">
            </div>

                <div class="form-group">
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

                </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
@parent

@endsection
