@extends('layouts.admin')

@section('content')


@can('lesson_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.scheduletemplate.create") }}">
                {{ trans('global.add') }} Template
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Schedule Template {{ trans('global.list') }}
    </div>
    @php
         $days = [1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday'];
    @endphp
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Template Name
                        </th>
                        <th>
                            Month Type
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scheduletemplates as $key => $template)
                        <tr data-entry-id="{{ $template->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $template->name ?? '' }}
                            </td>
                            <td>
                                {{ $template->type ?? '' }}
                            </td>
                            <td>
                                
                                @can('lesson_edit')
                                <a class="btn btn-xs btn-warning" href="{{ route('admin.scheduletemplate.detail', $template->id) }}">
                                    Schedule Template
                                </a>
                                @endcan

                                @can('lesson_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.scheduletemplate.edit', $template->id) }}">
                                        {{ trans('global.edit') }} Template
                                    </a>
                                @endcan

                              

                                @can('lesson_delete')
                                    <form action="{{ route('admin.scheduletemplate.destroy', $template->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

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
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('lesson_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "",
//     className: 'btn-danger',
//     action: function (e, dt, node, config) {
//       var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
//           return $(entry).data('entry-id')
//       });

//       if (ids.length === 0) {
//         alert('{{ trans('global.datatables.zero_selected') }}')

//         return
//       }

//       if (confirm('{{ trans('global.areYouSure') }}')) {
//         $.ajax({
//           headers: {'x-csrf-token': _token},
//           method: 'POST',
//           url: config.url,
//           data: { ids: ids, _method: 'DELETE' }})
//           .done(function () { location.reload() })
//       }
//     }
//   }
  
  //dtButtons.push(deleteButton)

@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
