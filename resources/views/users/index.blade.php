@extends('layouts.admin')
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
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
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
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $user->id ?? '' }}
                            </td>
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                {{ $user->phone ?? '' }}
                            </td>
                
                            <td>
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->roles->contains(3))
                                    @foreach($user->classteacher as $class)
                                        <span class="badge badge-success">{{ $class->name }}</span>
                                    @endforeach
                                @else
                                    {{ $user->class->name ?? '' }}
                                @endif
                            </td>
                            <td class="text-center">
                                {!! $user->rfidcard ? '<i class="fa fa-check" aria-hidden="true"></i>':'' !!}
                            </td>

                            <td>
                                @if($user->voice)
                                <input type="button" class="btn btn-sm btn-primary btn_play" value="Play">
                                <audio controls class="btn btn-sm" style="padding:0px;margin:0;display:none";              
                                        <source src="{{ asset('storage/audio/' . $user->voice) }}" type="audio/mp3">
                                </audio>
                                @endif
                            </td>
                            
                            <td>
                                @can('user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', ['user'=>$user->id,'role'=> request()->role]) }}">
                                        {{ trans('Collection Card') }}
                                    </a>
                                @endcan

                                @can('user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_delete')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.btn_play').click(function(){
        $(this).closest('td').find('audio')[0].play();
    });
})

</script>
@endsection
