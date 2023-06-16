@extends('layouts.admin')

@section('content')
@php

if(request()->has('cur_year'))
    $year = request()->input('cur_year');
else
    $year = date('Y');

 if(request()->has('cur_month'))
    $month = date('m', strtotime("$year-" . request()->input('cur_month') . "-1"));
 else
    $month = date('m');

 $prev = (int) $month -1;
 $prev_year = $year;
 if($prev<=0){
    $prev=12;
    $prev_year = $prev_year -1;
 }

 $next =  (int) $month +1;
 $next_year = $year;
 if($next > 12){
    $next=1;
    $next_year = $next_year + 1;
 }

    $strtime = strtotime("$year-$month-1");

    $cur_monthname = date("F",$strtime);

    $dayofmonth= date('t' , $strtime);

    $days = ['Su','Mo','Tu','We','Th','Fr','Sa'];

 @endphp

<div class="card">
    <div class="card-header">
        <div class="clearfix">
            <div class="float-left">Campus
           
                <a href="{{ route('admin.attendance.index') }}?cur_year={{ $year }}&cur_month={{ $month }}&campus=MC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='MC')?'active':'' }}' data-value='mc'>MC</a>
                <a href="{{ route('admin.attendance.index') }}?cur_year={{ $year }}&cur_month={{ $month }}&campus=CC" class='btn btn-sm btn-info campus {{ ($selected_campus->campus=='CC')?'active':'' }}' data-value='cc'>CC</a>
            </div>

            <div class="float-right">
                <a class='btn btn-primary' id='btn_notification' href="{{ route("admin.attendance.generate") }}">Generate Attendance for All Student</a>
                <a class='btn btn-success' id='btn_notification' href="{{ route("admin.attendance.create") }}">Register Attendance</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">

     <div class="row">   
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            @php
                $other=false;   
            @endphp
            <label for="class_list">Classes: </label>
            <select name="lst_class" class="select2" onchange='window.location="{{ route('admin.attendance.index', ['cur_month' => $month,'cur_year'=> $year, 'campus'=> $selected_campus->campus]) }}" + "&class=" + this.value ;'>
            @foreach ($schoolClasses as $key => $schoolClass)
                <option value="{{  $schoolClass->id }}" {{ ($schoolClass->id==$selected_class->id)?'selected':'' }} >{{ $schoolClass->name }}</option>
            @endforeach
            </select>
            {{-- @foreach($schoolClasses as $key => $schoolClass)
                @if($key<15)
                    @if($schoolClass->id==$selected_class->id)
                        @php $other=true; @endphp
                    @endif
                     <a href="{{ route('admin.attendance.index') }}?cur_year={{ $year }}&cur_month={{ $month }}&campus={{ $selected_campus->campus }}&class={{ $schoolClass->id }}" class="btn btn-secondary text-nowrap {{ ($schoolClass->id==$selected_class->id)?'active':'' }}">{{ $schoolClass->name }}</a>
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
                     <a href="{{ route('admin.attendance.index') }}?cur_year={{ $year }}&cur_month={{ $month }}&campus={{ $selected_campus->campus }}&class={{ $schoolClass->id }}" class="dropdown-item text-nowrap">{{ $schoolClass->name }}</a>
                @endif     
               @endforeach 
              </div>
            </div>
            @endif --}}
          </div>
     </div> 
    
     <div class="row">
        <div class="col-lg p-2">
            <a href="{{ route('admin.attendance.index') }}?cur_year={{ $prev_year }}&cur_month={{ $prev }}&campus={{ $selected_campus->campus }}&class={{ $selected_class->id }}" class="btn btn-primary btn-arrow-left">Prev Month</a>
        </div>

        <div class="col-lg p-2 text-center">
            <h2 class="text-primary">{{ $cur_monthname }}</h2>
        </div>

        <div class="col-lg p-2 text-right">
            <a href="{{ route('admin.attendance.index') }}?cur_year={{ $next_year }}&cur_month={{ $next }}&campus={{ $selected_campus->campus }}&class={{ $selected_class->id }}" class="btn btn-primary btn-arrow-left">Next Month</a>
        </div>
    
    </div>
    
     @php
         
     
    echo '<table class="table table-sm table-bordered">
            <tr>
                <td rowspan=2>Student ID</td>  
                <td rowspan=2>Student Name</td>';    
            $i=0;
            foreach($dateRanges as $date){
                echo '<td>'  . ++$i .  '</td>';
            }  
    echo '</tr><tr>';
        for($i=1;$i<=$dayofmonth;$i++){
                $date="$year-$month-$i";
                $day_of_week = date('w',strtotime($date));
                echo '<td>'  .  $days[$day_of_week] .  '</td>';
            }  
    echo '</tr>'; 
    
    foreach($students as $student){
        echo '<tr>';
            echo '<td>' . $student->email . '</td>';
            echo '<td>' . $student->name . '</td>';
            foreach($dateRanges as $date){
                echo '<td class="text-center">' .  ((array_key_exists($student->id, $attendances) && array_key_exists($date, $attendances[$student->id])) ? $attendances[$student->id][$date] :'')  .  '</td>';
            }
            // for($i=1;$i<=$dayofmonth;$i++){
            //     //$date="$year-$month-$i";
            //     $date = sprintf("%04d-%02d-%02d",$year,$month,$i);
            //  //   dd($date);
            //     $status=$student->getAttendance($date);
                
            //     switch(strtolower($status)){
            //         case 'present':
            //             $symbold='<i class="fas fa-check-circle text-primary"></i>';
            //             break;
            //         case 'absent & excused':
            //             $symbold='<i class="fas fa-times-circle text-warning"></i>';
            //             break;    
            //         case 'absent & unexcused':
            //             $symbold='<i class="fas fa-times-circle text-danger"></i>';
            //             break;     
            //         default:
            //             $symbold ='';      

            //     }
            //     echo '<td class="text-center">' . $symbold  .  '</td>';
            // }


        echo '</tr>';
    }
    
    echo '</table>';     
     @endphp    
     
  
        <div class="col-12 p-2 bg-light">
            Present: <i class="fas fa-check-circle text-primary"></i>, Absent & Excused: <i class="fas fa-times-circle text-warning"></i>, Absent & Unexcused: <i class="fas fa-times-circle text-danger"></i> 
        </div>
 
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
 
})

</script>
@endsection
