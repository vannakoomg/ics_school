<div class="table-responsive">
    <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
        <thead>
            <tr>
                <th width="10">

                </th>
                <th>
                    Posted Date
                </th>
                <th>
                    Class
                </th>
                <th>
                    Course
                </th>
                <th class="text-nowrap">
                    Lesson
                </th>
                <th class="text-nowrap">
                    Description
                </th>
                <th>
                    Category
                </th>
                <th class="text-nowrap text-center">
                    Status
                </th>
                
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
           @foreach ($elearnings as $elearning)
           <tr>
                <td> </td>
                <td>
                    {{ $elearning->created_at->format("d/m/Y") }}
               </td>
               <td>
                @foreach ($elearning->class as $class)
                    <span class="badge badge-pill badge-primary">{{ $class->name }}-{{ $class->campus }}</span>
                @endforeach
               
                </td>
                <td>
                    {{ $elearning->course->name ?? '' }}
                </td>
                <td><a href="{{ $elearning->url }}">{{ $elearning->lesson }}</a></td>
                <td>{{ $elearning->description ?? '' }}</td>
                <td>{{ $elearning->category }}</td>
                <td class="text-left">
                    {{ $elearning->active==1 ? 'Active':'Inactive' }}
                </td>
               
                
                <td class="text-center">
                  
                            <a class="btn btn-xs btn-primary text-nowrap" href="{{ route('admin.elearning.edit', $elearning->id) }}">
                                {{ trans('global.edit') }}
                            </a> 

                

                            <form action="{{ route('admin.elearning.changestatus', $elearning->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('put')
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ $elearning->active==1 ? 'Inactive':'Active' }}">
                            </form>
                   
                            <form action="{{ route('admin.elearning.destroy', $elearning->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                          

                </td>

            </tr>
           @endforeach
        </tbody>
    </table>
</div>