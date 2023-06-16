@extends('layouts.admin')

@section('styles')
    <style>

    </style>

@endsection
@section('content')

<Form  method="POST" action="{{ route("admin.attendance.generate") }}" enctype="multipart/form-data">
    @csrf
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg">Campus
           
            <a href="{{ route('admin.attendance.generate') }}?campus=MC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='MC')?'active':'' }}' data-value='mc'>MC</a>
            <a href="{{ route('admin.attendance.generate') }}?campus=CC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='CC')?'active':'' }}' data-value='cc'>CC</a>
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

          <h4 class="text-center">Generate Attendance for all students at campus {{ $selected_campus->campus }}</h4>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

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
                            Student Absent
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schoolClasses as $key => $schoolClass)
                
                        <tr data-entry-id="{{ $schoolClass->id }}">
                            <td>
                                {{-- <input type="hidden" name="class_id[]" value="{{ $schoolClass->id }}"> --}}
                                {{-- <input type="hidden" name="class_id[]" value="{{ $student->class->id }}"> --}}
                                {{-- @if(!empty($student_status))
                                     <i class="fas fa-calendar-check"></i>
                                @endif --}}
                            </td>
                            <td>
                                {{ $schoolClass->campus ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->name ?? '' }}
                                <input type="hidden" name="class_id[]" value="{{ $schoolClass->id }}">
                            </td>

                            <td>
                                <div  class="btn btn-sm btn-primary text-left">
                                    Total <span class="badge badge-light">{{ ($schoolClass->total ?? 0)  }}</span>
                                    
                                </div>
                                <div  class="btn btn-sm btn-success text-left">
                                    Present <span class="badge badge-dark">{{ ($schoolClass->total ?? 0) - ($schoolClass->absent_excused ?? 0) - ($schoolClass->absent_unexcused ?? 0) }}  </span>
                                   @php
                                        $student_present=$schoolClass->getStudentAttendances('Presentonly',date('Y-m-d'));
                                   @endphp
                                    <input type="hidden" name="present[]" value="{{ is_array($student_present)?join(",",$student_present):'' }}">
                                </div>

                                <div  class="btn btn-sm btn-warning text-left">
                                    Absent & Excused <span class="badge badge-dark">{{ $schoolClass->absent_excused ?? 0 }}</span>
                                    @php
                                    $student_absent_excused=$schoolClass->getStudentAttendances('Absent & Excused',date('Y-m-d'));
                                   @endphp
                                    <input type="hidden" name="absent_excused[]" value="{{ is_array($student_absent_excused)?join(",",$student_absent_excused):''  }}">
                                </div>

                                <div  class="btn btn-sm btn-secondary text-left">
                                    Absent & Unexcused <span class="badge badge-dark">{{ $schoolClass->absent_unexcused ?? 0 }}</span>
                                    @php
                                    $student_absent_unexcused=$schoolClass->getStudentAttendances('Absent & Unexcused',date('Y-m-d'));
                                   @endphp
                                    <input type="hidden" name="absent_unexcused[]" value="{{ is_array($student_absent_unexcused)?join(",",$student_absent_unexcused):''  }}">
                                </div>
                            </td>
                            <td>
                                @foreach($schoolClass->getAbsents('Absent & Excused') as $student)
                                    <span class="badge badge-warning">{{ $student->name }}</span></br>
                                @endforeach

                                @foreach($schoolClass->getAbsents('Absent & Unexcused') as $student)
                                    <span class="badge badge-secondary">{{ $student->name }}</span></br>
                                @endforeach
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button class="btn btn-danger pull-right" type="submit">
                Generate & {{ trans('global.save') }} 
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
