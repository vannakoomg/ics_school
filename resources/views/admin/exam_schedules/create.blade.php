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
        Exam Schedule Management
    </div>

    <div class="card-body">

        <p class="text-right" style="margin-bottom:0">
            <a href="#mission" class="btn btn-outline-primary btn_addform" data-toggle="collapse" data-target="#addform" aria-expanded="true"><i class="fa fa-angle-double-down text-lg-center"></i> Add Exam Schedule</a>
        </p>
        <div class="collapse" id="addform">

        <form method="POST" action="{{ route("admin.examschedule.store") }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Date</label>
                        <input type="text" class="form-control date" name="date" aria-describedby="emailHelp" placeholder="Date" value="{{ old('date') }}" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Start Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="start_time" aria-describedby="emailHelp" placeholder="" value="{{ old('start_time') }}" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">End Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="end_time" aria-describedby="emailHelp" placeholder="" value="{{ old('end_time') }}" required>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Title</label>
                        <input list="exam_title" type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Exam Title" value="{{ old('title') }}" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom-form" required multiple>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }} {{ ($class->id==request()->class_id) ? 'selected' : '' }}>{{ $class->name }}-{{ $class->campus }}</option>
                            @endforeach
                        </select>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="form-control" required>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }} {{ ($course->id==request()->course_id) ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                        </select>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">&nbsp;</label>
                        <button name="btn_save"  type="submit" class="btn btn-primary text-nowrap">Add New</button>
                        
                      </div>
                </div>
            </div>
        </form>
        <hr style="height:2px; width:90%; margin: 5px auto; border-width:0; color:red; background-color:red;" class="mb-3">
        </div>

        @include('admin.exam_schedules.filter')
        
        @include('admin.exam_schedules.exam_table')

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
