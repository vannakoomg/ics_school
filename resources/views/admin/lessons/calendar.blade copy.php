    <div class="row">
        <div class="col-2" id="teacher">
            
            <ul class="list-group">
                @foreach($teachers as $id => $teacher)
                    <li class="list-group-item list-group-item-info btn_teacher" data-value="{{  $id }}" style="border:solid 1px rgb(255, 255, 255) !important">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        {{ $teacher }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-lg-8">
            <table class="table table-sm table-bordered" id="tbl_timetable">
                <thead>
                    <th width="125">Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
               
                </thead>
                <tbody id="body">
                    @foreach($timetables as $timetable)
                    @php
                        $days = ['monday','tuesday','wednesday','thursday','friday']; //'saturday'

                        $data=[];

                        foreach ($days as $day) {
                                $data[$day] = [
                                'course' => $timetable->getcourse($day),
                                'teacher' => $timetable->getteacher($day),
                            ];     
                        }
                
                    @endphp
                    <tr>
                        <td class="text-nowrap">
                            {{ $timetable->start_time }} - {{ $timetable->end_time }}
                        </td>
                        @if (!empty($timetable->breaktime))
                            <td colspan="{{ count($days) }}" class="text-center align-middle {{ ($timetable->breaktime=='Break Time')?'table-active':'table-warning' }}">{{ $timetable->breaktime }}</td>
                            <td>
                                <a href="{{ route('admin.timetable.edit', $timetable->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.timetable.destroy', $timetable->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                        @else
                            @foreach ($days as $day)
                                <td class="" data-countteacher="{{ empty($data[$day]['teacher'])?0:1 }}" data-countcourse="{{ empty($data[$day]['course'])?0:1 }}" data-url="{{ route('admin.timetable.updatetimetable',$timetable->id) }}" data-urlremove="{{ route('admin.timetable.removetimetable',$timetable->id) }}" data-column='{{ $day }}'>
                                    @if(!empty($data[$day]['course']))
                                      <li class="list-group-item list-group-item-primary bg-success btn_course ui-draggable ui-draggable-handle" data-value="6" style="border: 1px solid rgb(255, 255, 255) !important; z-index: 6;">{{ $data[$day]['course'] }}</li>
                                    @endif
                                    @if(!empty($data[$day]['teacher']))  
                                        <li class="align-bottom list-group-item list-group-item-info btn_teacher ui-draggable ui-draggable-handle" data-value="6" style="border: 1px solid rgb(255, 255, 255) !important; z-index: 6;">{{ $data[$day]['teacher'] }}</li>
                                    @endif    
                                </td>
                            @endforeach
                            <td>
                                <a href="{{ route('admin.timetable.edit', $timetable->id) }}" class="btn btn-sm btn-primary">Edit Time</a>
                                <form action="{{ route('admin.timetable.destroy', $timetable->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                            
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
                    <li class="list-group-item list-group-item-primary bg-success btn_course" data-value="{{  $id }}" style="border:solid 1px rgb(255, 255, 255) !important">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        {{ $course }}</li>
                @endforeach
            </ul>
        </div>

    </div>