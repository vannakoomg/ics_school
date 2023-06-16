    <div class="row">
        <div class="col-2" id="teacher">
            
            <ul class="list-group">
                @foreach($teachers as $id => $teacher)
                    <li class="list-group-item border border-muted list-group-item-info btn_teacher" data-value="{{  $id }}">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        {{ $teacher }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-lg-8">
            <table class="table table-sm table-bordered khmer_os" id="tbl_timetable" style="border-color:#000">
                <thead>
                    <tr class="text-center">
                    <th>Time</th>
                    <th width="13%">Monday</th>
                    <th width="13%">Tuesday</th>
                    <th width="13%">Wednesday</th>
                    <th width="13%">Thursday</th>
                    <th width="13%">Friday</th>
                    <th width="13%">Saturday</th>
                    </tr>
                </thead>
                <tbody id="body">
                    @php
                        $pp=0;
                    @endphp
                    @foreach($scheduletemplatedetails as $timetable)
                    @php
                        $pp++;
                        $days = ['monday','tuesday','wednesday','thursday','friday','saturday']; 

                        $data=[];

                        foreach ($days as $day) {
                                $data[$day] = [
                                'course' => $timetable->getcourse($current_filter,$day),
                                'course_color' => $timetable->getcoursecolor($current_filter,$day),
                                'teacher' => $timetable->getteacher($current_filter,$day),
                                'tr_id' => $timetable->getcurrentid($current_filter),
                            ];     
                        }
                
                    @endphp
                    <tr>
                        <td class="text-nowrap align-middle">
				{{ $timetable->time }}       
			</td>
                        @if(strtolower($timetable->breaktime) != 'study time')
                            <td colspan="{{ count($days) }}" class="text-center align-middle 
                            @if($pp>1)
                                @if(strtolower($cuurent_class->level_type)=='primary')
                                        breaktime-bg-primary breaktime-color-primary
                                @elseif(strtolower($cuurent_class->level_type)=='secondary')
                                        breaktime-bg-secondary breaktime-color-secondary
                                @elseif(strtolower($cuurent_class->level_type)=='kindergarten')
                                        breaktime-bg-kindergarten breaktime-color-kindergarten
                                @endif
                            @endif

                            ">{{ $timetable->breaktime }}</td>
                           
                        @else
                            @foreach ($days as $day)
                                <td class="text-center" style="background-color:{{ $data[$day]['course_color'] }}" data-countteacher="{{ empty($data[$day]['teacher'])?0:1 }}" data-countcourse="{{ empty($data[$day]['course'])?0:1 }}" data-url="{{ route('admin.timetable.updatetimetable',$timetable->id) }}" data-urlremove="{{ route('admin.timetable.removetimetable',$timetable->id) }}" data-column='{{ $day }}' data-class_id='{{ $current_filter['class_id'] }}' data-template_id='{{ $current_filter['template_id'] }}' data-trid='{{ $data[$day]['tr_id'] }}'>
                                    @if(!empty($data[$day]['course']))
                                        <div class="btn_course ui-draggable ui-draggable-handle" data-value="6" style="z-index: 6; background-color:transparent"><strong>{{ $data[$day]['course'] }}</strong></div>
                                    @endif

                                    @if(!empty($data[$day]['teacher']))  
                                        <div class="align-bottom  btn_teacher ui-draggable ui-draggable-handle" data-value="6" style="z-index: 6;background-color:transparent">{{ $data[$day]['teacher'] }}</div>
                                    @endif    
                                </td>
                            @endforeach
                            
                            
                        @endif
                        
                    @endforeach
                    
                </tbody>
            </table>

                    {{-- <table class="table table-bordered">
                        <thead>
                            <th width="125">Time</th>
                            @foreach($weekDays as $day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </thead>
                        <tbody id="body">
                            @foreach($calendarData as $time => $days)
                                <tr>
                                    <td>
                                        {{ $time }}
                                    </td>
                                    @foreach($days as $value)
                                        @if (is_array($value))
                                            <td rowspan="{{ $value['rowspan'] }}" data-countteacher="0" data-countcourse="0"  class="align-middle text-center" style="background-color:#f0f0f0">
                                                {{ $value['class_name'] }}<br>
                                                Teacher: {{ $value['teacher_name'] }}
                                                @can('lesson_edit')
                                                    <a class="btn-link btn-xs" href="{{ route('admin.lessons.edit', $value['id']) }}">
                                                       {{ trans('global.edit') }}
                                                    </a>
                                                @endcan
                                            </td>
                                        @elseif ($value === 1)
                                            <td data-countteacher="0" data-countcourse="0"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
        </div>

        <div class="col-2" id="course">
            
            <ul class="list-group">
                @foreach($courses as $id => $course)
                
                    <li class="list-group-item border border-muted btn_course" data-color="{{ $course->color }}" data-value="{{  $course->id }}" style="background-color:{{ $course->color ?? '#f1f1f1' }}">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        <span class="khmer_os">{{  $course->name }}</span></li>
                @endforeach
            </ul>
        </div>

    </div>
