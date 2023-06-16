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
                    View Notification
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
                <span class="input-group-text">
                    {{ $message->title }}
                </span>
            </div>
            </div>
            <div class="col-2">
                <div class="xzoom-thumbs">
                    <img src="{{ asset('storage/image/' . $message->thumbnail) }}" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="{{ asset('storage/image' . $message->thumbnai) }}" width="150px" height="150px">
                </div> 
            </div>
            </div>
            <div class="form-group contain">
                    <label class="required" for="roles">{{ trans('Content') }}</label>
                    <div class="card card-body">
            
                        {!! $message->body !!}
               
                    </div>
            </div>

            <div class="form-group contain">
                <label class="required" for="roles">{{ trans('Class') }}</label>
                <div class="card card-body">
                    <div class="row">
                   @foreach ($message->classes as $class)
                        <div class="col-1">
                       <label class="bg-info px-4">{{ $class->name }}</label>
                        </div>
                   @endforeach
                    </div>
           
                </div>
        </div>

            <div class="form-group">
                <a class="btn btn-secondary" href="{{ route('admin.message.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
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
