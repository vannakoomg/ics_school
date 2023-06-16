@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.lesson.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.timetable.update", [$timetable->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                {{-- <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id" id="class_id" required>
                    @foreach($classes as $id => $class)
                        <option value="{{ $id }}" {{ ($id==$timetable->class_id) ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach
                </select> --}}
                <label class="form-control">{{ $classes[$timetable->class_id] }}</label>
                <input type="hidden" name="class_id" value="{{ $timetable->class_id }}"/>
                @if($errors->has('class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>
    
            <div class="form-group">
                <label class="required" for="start_time">{{ trans('cruds.lesson.fields.start_time') }}</label>
                <input class="form-control lesson-timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time', $timetable->start_time) }}" required>
                @if($errors->has('start_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.start_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_time">{{ trans('cruds.lesson.fields.end_time') }}</label>
                <input class="form-control lesson-timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time', $timetable->end_time) }}" required>
                @if($errors->has('end_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.end_time_helper') }}</span>
            </div>
                <div class="form-group">
                  @php
                    $breaktimes=['Study Time'=>'','Break time'=>'Break Time','Lunch Break'=> 'Lunch Break'];   
                  @endphp
                    <label class="" for="start_time">Break Time</label>
                  
                    <select name="breaktime" class="custom-select">
                         @foreach ($breaktimes as $key=>$value)
                              <option value="{{ $value }}" {{ $timetable->breaktime == $value ? 'selected' : '' }}>{{ $key }}</option>
                         @endforeach
                          
                          
                    </select>
                </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
