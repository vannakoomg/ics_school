@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
@endsection

@section('content')
@can('school_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.announcement.create") }}">
                {{ trans('global.add') }} {{ trans('News') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <form method="get" action="{{ route('admin.announcement.index') }}" id="form1">
        <span>
        {{ trans('global.list') }} of {{ trans('News ') }} 
        </span>
        <span class="float-right form-check form-switch">
            <input type="checkbox" name="chk_show" class="form-check-input" {{ request()->chk_show=="on"?"checked":"" }}>
              <label class="form-check-label" for="flexCheckDefault">
                Show Sent
              </label>
              
            </span>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('Date') }}
                        </th>
                        <th>
                            Thumbnail
                        </th>
                        <th>
                            {{ trans('Title') }}
                        </th>
                        {{-- <th>
                            {{ trans('Body') }}
                        </th> --}}
                        <th>
                            {{ trans('Posted by') }}
                        </th>
                        <th>
                            Sent
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($announcements as $announcement)
                   <tr>
                        <td> </td>
                        <td>
                            {{ $announcement->date }}
                        <br/>
                           <span class="text-muted">{{ $announcement->time }}</span> </td>
                        <td>
                            <div class="xzoom-thumbs text-left">
                                <img src="{{ asset('storage/image/' . $announcement->thumbnail) }}" class="btn btn-outline-primary xzoom-gallery img-thumbnail" id="img_thumbnail" xpreview="{{ asset('storage/image' . $announcement->thumbnai) }}" style="height: 100px; padding:0 !important;margin:0px">
                            </div>
                        </td>
                        <td>{{ $announcement->title }}</td>
                        {{-- <td>{!! $announcement->body !!}</td> --}}
                        <td>
                            {{-- @foreach ($announcement->classes as $class)
                                <span class="badge badge-primary">{{ $class->name }}</span>
                            @endforeach --}}
                            {{  $announcement->postedby }}
                        </td>
                        <td>
                            {{ ($announcement->send==1)?'Yes':'No' }}
                        </td>
                        <td>
                          
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.announcement.show', $announcement->id) }}">
                                        {{ trans('global.view') }}
                                    </a> 
                           
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.announcement.edit', $announcement->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                     
                                    <form action="{{ route('admin.announcement.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                           

                        </td>

                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script src="{{ asset('js/xzoom.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.js') }}"></script>
<script src="{{ asset('js/jquery.hammer.min.js') }}"></script>


<script>
    $(function () {

    $('input[type="checkbox"]').on("change", function(){
        $('#form1').submit();
    });  

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

  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 1, 'desc' ]],
    pageLength: 30,
  });
  $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
