@extends('layouts.admin')

@section('styles')
<style>
    /* Style the input field */
    #myInput {
      padding: 20px;
      margin-top: -6px;
      border: 0;
      border-radius: 0;
      background: #f1f1f1;
    }
    </style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Edit Exam Schedule 
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.examschedule.update",$examschedule->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
      
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Date</label>
                        <input type="text" class="form-control date" name="date" aria-describedby="emailHelp" placeholder="Date" value="{{ old('date', $examschedule->date_format) }}" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Start Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="start_time" aria-describedby="emailHelp" placeholder="Start Time" value="{{ old('start_time', $examschedule->start_time) }}" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">End Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="end_time" aria-describedby="emailHelp" placeholder="End Time" value="{{ old('end_time', $examschedule->end_time) }}" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Title</label>
                        <input list="exam_title" type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Exam Title" value="{{ old('title', $examschedule->title) }}" required>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom-form" required multiple>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }} {{ ($examschedule->class->contains($class->id)) ? 'selected' : '' }}>{{ $class->name }}-{{ $class->campus }}</option>
                            @endforeach
                        </select>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="form-control" required>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }} {{ ($course->id==$examschedule->course_id) ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                        </select>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">&nbsp;</label>
                        <button name="btn_save"  type="submit" class="btn btn-primary text-nowrap">Update</button>
                        
                      </div>
                </div>
            </div>
        </form>

        {{-- @include('admin.exam_schedules.filter') --}}
        
        {{-- @include('admin.exam_schedules.exam_table') --}}

    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    // $(document).ready(function(){
    //   $("#myInput").on("keyup", function() {
    //     var value = $(this).val().toLowerCase();
    //     $(".dropdown-menu li").filter(function() {
    //       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //     });
    //   });
    // });
    </script>
@endsection
