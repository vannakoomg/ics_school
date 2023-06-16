@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    <style>
        .khmer_os {
            font-family: 'Noto Sans Khmer', sans-serif;
            font-size:130%;
        }
    </style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
    <form name="frmcampus" method="get" action="{{ route("admin.homework.index") }}" enctype="multipart/form-data">
        <div class="row">

        <div class="col">
            <h3>Assignment {{ trans('global.list') }}</h3>
        </div>
        </div>
        <div class="row">
            <div class="col text-right">
                <div class="form-group row">
                    <label class=" col col-form-label" for="filter_status">Status</label>
                    <div class="col">
                          <select  class="custom-select" name="filter_status" id="filter_status" onchange="document.forms['frmcampus'].submit()">
                              @foreach($statuses as $id => $status)
                                  <option value="{{ $status }}" {{ old('filter_status') == $status ? 'selected' : '' }} {{ $status==$current_filter['status']?'selected':'' }}>{{ $status }}</option>
                              @endforeach
                          </select>
                    </div>         
                  </div>
                </div>

        <div class="col text-right">
            <div class="form-group row">
                <label class=" col col-form-label" for="class_id">Term</label>
                <div class="col">
                      <select  class="custom-select" name="filter_term" id="filter_term" onchange="document.forms['frmcampus'].submit()">
                          @foreach($terms as $id => $term)
                              <option value="{{ $term }}" {{ old('filter_term') == $term ? 'selected' : '' }} {{ $term==$current_filter['term']?'selected':'' }}>{{ $term }}</option>
                          @endforeach
                      </select>
                </div>         
              </div>
            </div>

        <div class="col text-right">
            <div class="form-group row">
                <label class=" col col-form-label" for="class_id">Class</label>
                <div class="col">
                      <select  class="custom-select" name="filter_class" id="filter_class" onchange="document.forms['frmcampus'].submit()">
                          @foreach($classes as $id => $class)
                              <option value="{{ $id }}" {{ old('filter_class') == $id ? 'selected' : '' }} {{ $id==$current_filter['class']?'selected':'' }}>{{ $class }}</option>
                          @endforeach
                      </select>
                </div>         
              </div>
            </div>
         <div class="col  text-right">
            <div class="form-group row text-nowrap">
            <label class="col col-form-label" for="class_id">Language</label>
            <div class="col-6">
                  <select  class="custom-select" name="filter_language" id="filter_language" onchange="document.forms['frmcampus'].submit()">
                      @foreach($languages as $id => $language)
                          <option value="{{ $language }}" {{ old('filter_language') == $language ? 'selected' : '' }} {{ $language==$current_filter['language']?'selected':'' }}>{{ $language }}</option>
                      @endforeach
                  </select>
            </div>  
            </div> 
         </div>  
         
         <div class="col text-right">
            <div class="form-group row">
            <label class=" col col-form-label" for="filter_course">Course</label>
            <div class="col-8">
                  <select  class="custom-select" name="filter_course" id="filter_course" onchange="document.forms['frmcampus'].submit()">
                      @foreach($courses as $id => $course)
                          <option value="{{ $id }}" {{ old('filter_course') == $id ? 'selected' : '' }} {{ $id==$current_filter['course']?'selected':'' }}>{{ $course }}</option>
                      @endforeach
                  </select>
            </div>  
            </div> 
         </div>  

        </div>

  
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display table-striped" id="tbl_homework" style="width:100%">
                <thead>
                    <tr>
                        <th width="10">
                            No
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Created Date
                        </th>    
                        <th>
                            Due Date
                        </th>    
                        <th>
                            Assigned Course
                        </th>                
                        <th>
                            Title
                        </th>
                        <th>
                            Marks
                        </th>
                        <th>
                            Class
                        </th>
                        
                        <th>
                            Student Submit
                        </th>
                        {{-- <th>
                            Remark
                        </th> --}}
                        <th>
                            #
                        </th>
                    </tr>
                </thead>
           
            </table>
        </div>
    </div>
</div>
{{-- @php
print_r(json_encode($current_filter));
exit();
@endphp --}}
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/xzoom.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.js') }}"></script>
<script src="{{ asset('js/jquery.hammer.min.js') }}"></script>
<script>
    $(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

   // $.fn.dataTable.ext.errMode = 'none';

        var classes ='', language='', course ='';

        var table1 = $('#tbl_homework').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        destroy: true,
        processing: false,
        serverSide: true,
        paging: true,
        bFilter: true,
        bInfo:true,
        order: [[1, 'desc']],
        // columnDefs: [{ visible: false, targets: 1 }],
       // "ordering": false,
        // oLanguage:{
        //     "sSearch":'Search only[Student ID, English Name]: '
        // },
       // "deferLoading": 0,
        ajax: {
            'dataType':'json',
            url:"{{ route('admin.homework.ajaxhomework') }}?completed=0",
            'data': {'filter': {!! json_encode($current_filter) !!} }
        },
        cache:false,
        // buttons: [],
        select: false,
        columnDefs:[
            {
            'targets':[1],
            'visible':false,
            
            },
            {
             'targets':[0,2,3,4,5,6,7,8,9],
             'orderable': false 
            }
        ],
       
        columns: [
            {data: 'DT_RowIndex', 
            // name : 'DT_RowIndex',
            // "render": function(data,type){
                
            //     return '<h5 class="text-center p-2 m-0">' + (data + (next_page -1) * lengthrow) + '</h5>';
            // },
            class:'text-center align-middle ext-weight'
           
            },
            {data: 'group_col',name:'group_col',class:' align-middle text-weight-normal'},
            {data: 'added_on_date',name:'added_on_date',class:' align-middle text-weight-normal'},
            {data: 'due_date', name : 'due_date' ,  class:' align-middle text-weight-normal'},
            {data: 'course_name', name : 'course_name',class:'text-weight-normal align-middle'},
            {data: 'name', name : 'name',class:'align-left align-middle text-weight-normal'},
            {data: 'marks', name : 'marks', class:'align-middle text-weight-normal'},
            {data: 'class_name', name : 'class_name', class:'text-weight-normal align-middle'},
            
        //    {data: 'submitted', name : 'submitted',class:'text-weight-normal align-middle text-center'},
            {data: 'student_submit', name : 'student_submit',class:'text-center align-middle'},
            {data: 'action', name : 'action',class:'text-left text-nowrap align-middle'},
            
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
 
            api
                .column(1, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before('<tr class="group bg-primary text-white"><td colspan="10"><strong>' + group + '</strong></td></tr>');
 
                        last = group;
                    }
                });
        },
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
@can('school_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  
  $.extend(true, $.fn.dataTable.defaults, {
    //order: [[ 1, 'desc' ]],
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
