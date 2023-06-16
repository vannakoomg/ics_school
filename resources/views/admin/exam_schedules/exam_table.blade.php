<p class="mb-1">&nbsp;</p>
       <table border="0" class="table table-sm table-bordered">
           <thead>

           <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Exam Title</th>
               @foreach ($dayweeks as $dayweek)
                   <th>{{ $dayweek }}</th>
               @endforeach
               
            <th></th>  
           </tr>
           </thead>
           <tbody>
               @foreach ($examschedules as $examschedule)
                   <tr>
                        <td>{{ $examschedule->date_format }}  </td>
                        <td>{{ $examschedule->start_time }} to {{ $examschedule->end_time }}</td>
                        <td>{{ $examschedule->title }}</td>
                        @foreach ($dayweeks as $i => $dayweek)
                          
                            @if($i==$examschedule->dayweek)
                                <td class="text-center">
                                    @foreach ($examschedule->class as $class)
                                            {{-- <span class="badge badge-pill badge-primary">{{ $class->name }}-{{ $class->campus }}</span> --}}
                                            <div class="p-0 mb-1 bg-success text-white">{{ $class->name }}-{{ $class->campus }}</div>
                                     @endforeach
                                    
                                    <div class="p-0 mb-1 bg-primary text-white">{{ $examschedule->course->name ?? ''}}</div>
                
                                 </td>
                            @else
                                <td>&nbsp;</td>
                            @endif
                             
                        @endforeach
                        <td>
                            <a href="{{ route('admin.examschedule.edit',$examschedule->id) }}" class="bth btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.examschedule.destroy', $examschedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>

                        </td>
                    </tr>
               @endforeach
           </tbody>
       </table>