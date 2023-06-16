@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
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
                    View Feedback
                </div>
   @php
    $roles=[];

   @endphp
    <div class="card-body">

        <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="{{ route("admin.feedback.update",$feedback->id) }}" >
            @method('PUT')
            @csrf
            <div class="row">
                
            <div class="col-2">
                <div class="form-group">
                    <label class="required" for="name">{{ trans('Date') }}</label>
                    <span class="input-group-text">
                        {{ $feedback->date }}
                    </span>
                </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('Posted By') }}</label>
                        <span class="input-group-text">
                            {{ $feedback->student->name }}
                        </span>
                    </div>
                    </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="" for="name">{{ trans('Category') }}</label>
                        <span class="input-group-text">
                            {{ $feedback->category }}
                        </span>
                    </div>
                    </div>
                <div class="col-4">
                        <div class="form-group">
                            <label class="" for="name">{{ trans('Student Class') }}</label>
                            <span class="input-group-text">
                                {{ $feedback->student->class->name ?? '' }}-{{ $feedback->student->class->campus ?? '' }}
                            </span>
                        </div>
                        </div>    
            <div class="col-2">
                <div class="xzoom-thumbs">
                    @if(!empty($feedback->image))
                        <img src="{{ asset('storage/image/' . $feedback->image) }}" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="{{ asset('storage/image' . $feedback->thumbnai) }}" width="150px" height="150px">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="btn btn-outline-primary" width="150px" height="150px">
                    @endif
                </div> 
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles">{{ trans('Parents Question') }}</label>
                    <div class="card card-body">
            
                        {!! $feedback->question !!}
               
                    </div>
            </div>
            <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="" for="name">{{ trans('Reply By') }}</label>
                    <span class="input-group-text">
                        {{ $feedback->replyer ?? Auth::user()->name }}
                    </span>
                </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="" for="name">{{ trans('Reply At') }}</label>
                        <span class="input-group-text">
                            {{ $feedback->replied_at ?? date("d/m/Y h:i A") }}
                        </span>
                    </div>
                    </div>   

            </div>    
            <div class="form-group contain">
                <label class="required" for="roles">{{ trans('Reply Message') }}</label>
                <div class="card card-body">
                    @if($feedback->reply=='1')
                        {!! $feedback->answer !!}
                    @else
                        <textarea name="answer" required>{{ $feedback->answer ?? '' }}</textarea>
                    @endif
           
                </div>
        </div>
            <div class="form-group">
                <a class="btn btn-secondary" href="{{ route('admin.feedback.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>

                <button type="submit" class="btn btn-primary pull-right" {{ ($feedback->reply==1)?'disabled':'' }}>
                    {{ trans('Reply & Send Notification') }}
                </button>
            </div>
        </form>
    </div>

@endsection
@section('scripts')
@parent
<script src="{{ asset('js/xzoom.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.js') }}"></script>
<script src="{{ asset('js/jquery.hammer.min.js') }}"></script>

<script>
$(document).ready(function() {
        
        // $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});
         
         $('.xzoom-gallery').bind('click', function(event) {
                 var div= $(this).parents('.xzoom-thumbs');
                 // var xzoom = $(this).data('xzoom');
                 // xzoom.closezoom();
                 // var gallery = xzoom.gallery().cgallery;
                 // var i, images = new Array();
                 // for (i in gallery) {
                 //     images[i] = {src: gallery[i]};
                 // }
                 images = new Array();
 
                 var img_length = div.find('img').length;
                 for(i=0;i<img_length;i++)
                    images[i]= {src: div.find('img').eq(i).attr("src")};
                 $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                 event.preventDefault();
             });
     });
</script>
@endsection
