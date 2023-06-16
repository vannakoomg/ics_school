@extends('layouts.admin')
@section('styles')
    <style>
        table.datatable td {
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @can('user_create')
            <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
            @endcan
            @can('school-setup')
            <a class="btn btn-success" href="{{ route("admin.users.create") }}?teacher">
                {{ trans('global.add') }} New Teacher
            </a>
            
            <a class="btn btn-success" href="{{ route("admin.users.create") }}?student">
                {{ trans('global.add') }} New Student
            </a>

            <a class="btn btn-info" href="{{ route("admin.users.pickup_report") }}?student">
                Pickup Repot Card
            </a>

            <a class="btn btn-primary" href="{{ route("admin.student.promote") }}?student">
                 Student Promote
            </a>

            @endcan
        </div>
    </div>

<div class="card">
    <div class="card-header">
        <form name="frmcampus" method="get" action="{{ route("admin.users.index") }}" enctype="multipart/form-data">
            <div class="row">
            <div class="col">
                {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
            </div>
            @if(in_array(request()->role,[3,4]))
            <div class="col">
                <div class="form-group row">
                    <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
                    <div class="col-sm-9">
                          <select  class="custom-select {{ $errors->has('campus') ? 'is-invalid' : '' }}" name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                              @foreach($campus as $id => $key)
                                  <option value="{{ $key }}" {{ old('campus') == $key ? 'selected' : '' }} {{ $key==$current_filter['campus']?'selected':'' }}>{{ $key }}</option>
                              @endforeach
                          </select>
                    </div>      
                  </div>
                </div>
            </div>
            <input type="hidden" name="role" value="{{ request()->role ?? '' }}"/>
            @endif
            </form>
       
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ 'Photo' }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th class="text-nowrap">
                            {{ (Request()->role==4)?'Student ID':trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ 'Phone' }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.class') }}
                        </th>
                       
                       <th>
                        Course
                       </th>
                        
                        <th>
                            RFID
                        </th>
                        <th width="30px">
                            Voice
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  
 var dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).attr('id');
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
    // order: [[ 3, 'desc' ]],
    pageLength: 50,
  });
  
//   $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

let selectCampus = "{{ request('campus') }}";
let role = "{{ request('role') }}";
console.log(role);
var table = $('.datatable-User').DataTable({
        buttons: dtButtons, 
       // destroy: true,
        processing: true,
        serverSide: true,
        paging: true,
        bFilter: true,
        // bInfo:false,
        // "ordering": true,
        // oLanguage:{
        //     "sSearch":'Search only[Student ID, English Name]: '
        // },
       // "deferLoading": 0,
        ajax: {
            url:"{{ route('admin.user.ajaxlist') }}?campus=" + selectCampus + '&role=' + role,
        },
        cache:false,
        columnDefs: [
            {
                visible: false,
                targets: ((role==3)?9:7)
            },
            {
            orderable: false,
            className: 'select-checkbox align-bottom',
            targets:0
        }, {
            orderable: false,
            searchable: false,
            targets: -1
        }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
        columns: [
            {defaultContent:''},
            {data: 'photo', name : 'photo'},
            {data: 'fullname', name : 'fullname',class:'p-2 text-left align-middle'},
            {data:'email',name:'email'},
            {data:'phone',name:'phone'},
            {data:'roles',name:'roles'},
            {data:'classes',name:'classes'},
            {data:'course_name',name:'course_name'},
            {data:'rfid',name:'rfid'},
            {data:'voice',name:'voice'},
            {data:'action',name:'action'}
        ],
        "fnDrawCallback": function(oSettings){
            $('.datatable-User tbody td').find('form').submit(function(e){
                //e.preventDefault();
                return confirm('{{ trans('global.areYouSure') }}');
            })

            $('.btn_play').click(function(){
                $(this).closest('td').find('audio')[0].play();
            });
        }
        });
    });
</script>
@endsection
