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
    
    </div>

<div class="card">
    <form name="frmcampus" method="get" action="{{ route("admin.student.promote") }}" enctype="multipart/form-data">
    <div class="card-header">
        
            <div class="row">
            <div class="col">
               Student Promote
            </div>
            {{-- @if(in_array(request()->role,[3,4])) --}}
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
            {{-- @endif --}}
            
       
    </div>

 
    <div class="card-body">

        <div class="row">
            <div class="col-6">
                <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Current Class</label>
                <div class=" col-sm-8">
                        <select class="custom-select" name="cur_class" id="cur_class" onchange="document.forms['frmcampus'].submit()">
                            @foreach ($classes as $id=>$class)
                                 <option value="{{ $id }}" {{ $id==request()->input('cur_class') ? 'selected':'' }}>{{ $class }}</option>
                            @endforeach
                           
                        </select>
                </div>
                </div>
                <div class="table-responsive">
                   
                    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                            <tr>
                                <th width="10">
                                    <input type="checkbox" value="1" id='checkall'>
                                </th>
                                <th>
                                    {{ 'Photo' }}
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th>
                                    {{  'Student ID' }}
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($cur_user as $user)
                                    <tr>
                                        <td><input type="checkbox" value="{{ $user->id }}" name="chk[]"/></td>
                                        <td>
                                        <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                                            {!! '<img clas="img-fluid img-thmbnail" src="' . (!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))  . '" style="width:100%;height:auto">' !!}
                                        </div>
                                        </td>
                                        <td>{{ $user->name ?? '' }}<br>{{ $user->namekh }}</td>
                                        <td>{{  $user->email }}</td>

                                    </tr>
                                @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </form>
            </div>

            <div class="col-6">
    
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Promote Class</label>
                    <div class=" col-sm-6">
                        <select class="custom-select" name="new_class" id='new_class' onchange="document.forms['frmcampus'].submit()">
                        @foreach ($classes as $id=>$class)
                             <option value="{{ $id }}" {{ $id==request()->input('new_class') ? 'selected':'' }}>{{ $class }}</option>
                        @endforeach
                       
                    </select>

                  
                    </div>
                    <div class=" col-sm-2">
                        <input type="submit" class="btn btn-primary" value="Promote" name="btn_promote"/>
                    </div>
                    </div>

                <div class="table-responsive">
                    

                    <table class=" table table-bordered table-striped table-hover datatable">
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
                                <th>
                                    {{  'Student ID' }}
                                </th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($new_user as $user)
                                <tr>
                                    <td></td>
                                    <td>
                                        <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                                            {!! '<img clas="img-fluid img-thmbnail" src="' . (!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))  . '" style="width:100%;height:auto">' !!}
                                        </div>
                                    </td>
                                    <td>{{ $user->name ?? '' }}<br>{{ $user->namekh }}</td>
                                    <td>{{  $user->email }}</td>

                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  


  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 3, 'desc' ]],
    pageLength: 50,
    searching: false, paging: false, info: false,
    buttons:[],
    select: {
        style:    'multi',
        selector: 'td:first-child'
    },
    });

  //$('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.btn_play').click(function(){
        $(this).closest('td').find('audio')[0].play();
    });


    $('#checkall').click(function(){
       
        if($(this).is(':checked'))
            $('.datatable-User input:checkbox').prop('checked',true);
        else
            $('.datatable-User input:checkbox').prop('checked',false);
    });

    $('form').submit(function () {

// Get the Login Name value and trim it
        
        if ($('#cur_class').val() == '' || $('#new_class').val()=='') {
            alert('Current Class and New Class are required.');
            return false;
        }
      // console.log($('.datatable-User input:checkbox:checked').length);
        if($('.datatable-User input:checkbox:checked').length==0){
            alert('Checkbox required select at less 1.');
            return false;
        }

        if(!confirm('Are you sure to promote ' + $('.datatable-User input:checkbox:checked').length + ' selected student?'))
            return false;

});


})

</script>
@endsection
