@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
@endsection

@section('content')
@can('school_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
         
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
<form method="get" action="{{ route('admin.feedback.index') }}" id="form1">
        <span>
        Parent Feedback List
        </span>

        <span class="float-right form-check form-switch">
            <input type="checkbox" name="chk_show" class="form-check-input" {{ request()->chk_show=="on"?"checked":"" }}>
              <label class="form-check-label" for="flexCheckDefault">
                Show Replied
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
                            Attachment
                        </th>
                        <th class="text-nowrap">
                            Posted By
                        </th>
                        <th width="100px">
                            Student Class
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            {{ trans('Question') }}
                        </th>
                        {{-- <th>
                            {{ trans('Body') }}
                        </th> --}}
                        
                        <th>
                            Replied
                        </th>
                        <th class="text-nowrap">
                            {{ trans('Reply by') }}
                        </th>
                        <th class="text-nowrap">
                            {{ trans('Reply At') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($feedbacks as $feedback)
                   <tr>
                        <td> </td>
                        <td>
                            {{ $feedback->date }}
                        <br/>
                           <span class="text-muted">{{ $feedback->time }}</span> </td>
                        <td>
                            <div class="xzoom-thumbs text-left">
                                @if(!empty($feedback->image))
                                    <img src="{{ asset('storage/image/' . $feedback->image) }}" class="xzoom-gallery img-thumbnail btn btn-outline-primary" id="img_thumbnail" xpreview="{{ asset('storage/image' . $feedback->thumbnai) }}" style="height: 100px !important">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" class="btn btn-outline-primary"  height="100px">
                                @endif
                            </div>
                        </td>
                        <td>{{ $feedback->student->name }}</td>
                        <td>
                            {{ $feedback->student->class->name ?? ''}}-{{ $feedback->student->class->campus ?? '' }}
                        </td>
                        <td>{{ $feedback->category ?? '' }}</td>
                        <td>{{ $feedback->question }}</td>
                        <td class="text-center">
                            {{ ($feedback->reply==1)?'Yes':'No' }}
                        </td>
                       
                        <td>
                        
                        {{  $feedback->replied_by }}
                        </td>
                        
                        <td>
                        
                            {{  $feedback->replied_at }}
                            </td>
                        
                        <td>
                          
                                    <a class="btn btn-xs btn-primary text-nowrap" href="{{ route('admin.feedback.show', $feedback->id) }}">
                                        {{ trans('global.view') }} & Reply
                                    </a> 
                           
                                  

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
    pageLength: 100,
  });
  $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
