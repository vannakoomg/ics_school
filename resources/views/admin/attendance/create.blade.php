@extends('layouts.admin')

@section('styles')
    <style>

    </style>

@endsection
@section('content')

<Form  method="POST" action="{{ route("admin.attendance.store") }}" enctype="multipart/form-data">
    @csrf
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg">Campus
           
            <a href="{{ route('admin.attendance.create') }}?campus=MC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='MC')?'active':'' }}' data-value='mc'>MC</a>
            <a href="{{ route('admin.attendance.create') }}?campus=CC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='CC')?'active':'' }}' data-value='cc'>CC</a>
            </div>
            <div class="col-lg text-center">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                       <input type='text' class="form-control date" name="txt_date" readonly value="{{ date('d/m/Y') }}" required />
                       <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>

            </div>
            
            <div class="col-lg text-right">
            <a class='btn btn-secondary' id='btn_notification' href="{{ route("admin.attendance.index") }}">Back to List</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">
      
        <div class="form-group">
            @php
                $other=false;   
            @endphp
            <div class="row">
                <div class="col-1">
             <label for="class_list">Classes: </label>
                </div>
             <div class="col-11">
             <select name="lst_class" class="select2" onchange='window.location="{{ route('admin.attendance.create', ['campus'=> $selected_campus->campus]) }}" + "&class=" + this.value ;'>
             @foreach ($schoolClasses as $key => $schoolClass)
                 <option value="{{  $schoolClass->id }}" {{ ($schoolClass->id==$selected_class->id)?'selected':'' }} >{{ $schoolClass->name }}</option>
             @endforeach
             </select>
                </div>
            </div>
            {{-- @foreach($schoolClasses as $key => $schoolClass)
                @if($key<15)
                    @if($schoolClass->id==$selected_class->id)
                        @php $other=true; @endphp
                    @endif
                     <a href="{{ route('admin.attendance.create') }}?campus={{ $selected_campus->campus }}&class={{ $schoolClass->id }}" class="btn btn-secondary text-nowrap {{ ($schoolClass->id==$selected_class->id)?'active':'' }}">{{ $schoolClass->name }}</a>
                @endif     
            @endforeach
          
            @if($schoolClasses->count()>15)
            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle {{ ($other==false)?'active':'' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $other?'More...':$selected_class->name }}
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                @foreach($schoolClasses as $key => $schoolClass)
                @if($key>=15)
                     <a href="{{ route('admin.attendance.create') }}?campus={{ $selected_campus->campus }}&class={{ $schoolClass->id }}" class="dropdown-item text-nowrap">{{ $schoolClass->name }}</a>
                @endif     
               @endforeach
              </div>
            </div>
            @endif --}}
          </div>

          <p>&nbsp;</p>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Student ID
                        </th>
                        <th>
                            {{ trans('cruds.schoolClass.fields.name') }}
                        </th>
                        <th>
                            Campus
                        </th>
                        <th>
                            Class
                        </th>
                        <th>
                            Attendance
                        </th>
                        <th>
                            Remark
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $key => $student)
                    @php
                        $student_status = (array_key_exists($student->id, $attendances) ? $attendances[$student->id] : '');//$student->getAttendance(date('Y-m-d'));
                    @endphp
                        <tr data-entry-id="{{ $schoolClass->id }}">
                            <td>
                                <input type="hidden" name="student_id[]" value="{{ $student->id }}">
                                {{-- <input type="hidden" name="class_id[]" value="{{ $student->class->id }}"> --}}
                                @if(!empty($student_status))
                                     <i class="fas fa-calendar-check"></i>
                                @endif
                            </td>
                            <td>
                                {{ $student->email ?? '' }}
                            </td>
                            <td>
                                {{ $student->name ?? '' }}
                            </td>
                              <td>
                                {{ $student->class->campus ?? '' }}
                            </td>

                            <td>
                                {{ $student->class->name ?? '' }}
                            </td>
                            <td>
				 <select name="txt_status[]" id="txt_status" class="select2">
                                 	 @foreach ($status as $s)
                                        	<option value="{{ $s }}" {{ ($student_status==$s)?'selected':'' }}>{{ $s }}</option>
                                        @endforeach
                                        
                                </select>

                                
                            </td>

                            <td>
                                <input type="text" name="txt_remark[]" id="txt_remark" class="form-control" value="{{ old('txt_remark', $student->getRemark(date('Y-m-d')) ) }}">
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button class="btn btn-danger pull-right" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </div>
</div>
</Form>


@endsection
@section('scripts')
@parent
<script>
    $(function () {
     
    });

</script>
@endsection
