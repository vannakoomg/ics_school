

        <form method="POST" action="{{ route("admin.elearning.create") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="search" value="search"/>
        <div class="row">
 
          @php
              //dd(join("|",array_column($classes->toArray(), 'name')));
          @endphp

            <div class="col-lg">
                <label class="form-label">Class Filter</label>
                {{-- pattern="^{{ join("|",array_column($classes->toArray(), 'name')) }}$" --}}
                <input list="class_filter" class="form-control" name="class_filter"  value="{{ old('class_filter',$current_filter['class_filter']) }}" placeholder="Search / Select">
                
                <datalist id="class_filter">
                    @foreach ($classes as $class)
                    <option data-value="{{ $class->id }}">{{ $class->name }}-{{ $class->campus }}</option>
                      {{-- <option value="{{ $class->id }}">{{ $class->name }}</option> --}}
                    @endforeach
                </datalist>
            </div>


            <div class="col-lg">
                <label class="form-label">Course Filter</label>
                <input list="course_filter" class="form-control" name="course_filter" pattern="^({{ join("|",array_column($courses->toArray(), 'name')) }})$" value="{{ old('course_filter',$current_filter['course_filter']) }}" placeholder="Search / Select">
                
                <datalist id="course_filter">
                  @foreach ($courses as $course)
                    <option value="{{ $course->name }}">
                  @endforeach
                </datalist>
            </div>

            <div class="col-lg">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="form-control btn btn-primary">Search...</button>
            </div>

        </div>
        </form>