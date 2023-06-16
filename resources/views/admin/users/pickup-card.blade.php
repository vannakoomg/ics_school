@extends('layouts.admin')

@section('styles')
    <style>

    </style>

@endsection
@section('content')

<Form  method="POST" action="{{ route("admin.users.pickup_report") }}" enctype="multipart/form-data">
    @csrf
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg">Campus
           
            <a href="{{ route('admin.users.pickup_report') }}?student&campus=MC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='MC')?'active':'' }}' data-value='mc'>MC</a>
            <a href="{{ route('admin.users.pickup_report') }}?student&campus=CC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='CC')?'active':'' }}' data-value='cc'>CC</a>
            </div>
            <div class="col-lg text-center">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                       {{-- <input type='text' class="form-control date" name="txt_date" readonly value="{{ date('d/m/Y') }}" required /> --}}
                       <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>

            </div>
            
            <div class="col-lg text-right">
            <a class='btn btn-secondary' id='btn_notification' href="{{ route("admin.users.index") }}?role=4">Back to Student List</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">
      
        <div class="form-group">
            @php
                $other=false;   
            @endphp
            <input type="hidden" name="campus" value="{{ request()->input('campus') ?? 'MC' }}"/>
            <div class="row">
                <div class="col-1">
             <label for="class_list">Class: </label>
                </div>
             <div class="col-11">
             <select name="class" class="select2 custom-select" onchange='window.location="{{ route('admin.users.pickup_report', ['campus'=> $selected_campus->campus]) }}" + "&class=" + this.value ;'>
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
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $student)
                    @php
                        $student_status = $student->guardian1;
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

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button class="btn btn-primary float-left m-2" type="submit" name="btn_preview">
                Preview
            </button>
            <button class="btn btn-info float-right m-2" type="submit" name="btn_pdf_front">
                Print (Front side) Pdf
            </button>
            <button class="btn btn-info float-right m-2" type="submit" name="btn_pdf_back">
                Print (Back side) Pdf
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
