    <div class="row">
        
        <div class="col-lg-12">
            <table class="table table-sm table-bordered" id="tbl_timetable">
                <thead class="text-center">
                    <th width="125">Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th width="110px"></th>
                </thead>
                <tbody id="body">
                    @foreach($scheduletemplatedetails as $detail)
                    <tr>
                        <td class="text-nowrap">
                            {{ $detail->time }}
                        </td>
                        @if(!in_array($detail->breaktime,['Study Time']))
                            <td colspan="{{ count($days) }}" class="text-center align-middle" style="background-color:{{ ($detail->breaktime=='Break Time')?'#A04E48':'#C9D9EF' }}">{{ $detail->breaktime }}</td>
                            <td>
                                <a href="{{ route('admin.scheduletemplatedetail.edit', $detail->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.scheduletemplatedetail.delete', $detail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                        @else
                            @foreach ($days as $day)
                                <td>&nbsp;</td>
                            @endforeach
                            <td>
                                <a href="{{ route('admin.scheduletemplatedetail.edit', $detail->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.scheduletemplatedetail.delete', $detail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                            
                        @endif
                        
                    @endforeach
                    
                </tbody>
            </table>

        </div>

    </div>