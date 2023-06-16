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
        E-Learning Management (Edit Form)
    </div>

    <div class="card-body">

        <p class="text-right" style="margin-bottom:0">
            <a href="#mission" class="btn btn-outline-primary btn_addform" data-toggle="collapse" data-target="#addform" aria-expanded="true"><i class="fa fa-angle-double-down text-lg-c  enter"></i> Edit Lesson</a>
        </p>
        <div class="collapse show" id="addform">

        <form method="POST" action="{{ route("admin.elearning.update",$elearning->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="class_id" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom_form" required multiple>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }} {{ ($elearning->class->contains($class->id)) ? 'selected' : '' }}>{{ $class->name }}-{{ $class->campus }}</option>
                        @endforeach
                        </select>
                        
                      </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="select2 form-control" required>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }} {{ ($course->id==$elearning->course_id) ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                        </select>
                        
                      </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="url" class="required">Category</label>
                        <div class="row">
                        <input type="checkbox" data-width="130" name="category" data-toggle="toggle" {{ $elearning->category=='Video'?'checked':'' }} class="text-nowrap" data-onstyle="primary" data-offstyle="secondary" data-on="<i class='fa fa-play'></i> Video" data-off="<i class='fa fa-book'></i> Document">
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="lesson" class="required">Lesson</label>
                        <input type="text" class="form-control" name="lesson" aria-describedby="emailHelp" placeholder="Lesson Title" value="{{ old('lesson', $elearning->lesson) }}" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="description" class="required">Description</label>
                        <input  type="text" class="form-control" name="description" aria-describedby="emailHelp" placeholder="Lesson Description" value="{{ old('description', $elearning->description) }}" required>
                        
                      </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="url" class="required">URL/Link</label>
                        <input  type="text" class="form-control" name="url" aria-describedby="emailHelp" placeholder="Video or Pdf Link" value="{{ old('url', $elearning->url) }}" required>
                        
                      </div>
                </div>
                

                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">&nbsp;</label>
                        <div class="row">
                        <button name="btn_save"  type="submit" class="btn btn-primary text-nowrap"> &nbsp;Save&nbsp;</button>
                        </div>
                        
                      </div>
                </div>
            </div>
        </form>
        {{-- <hr style="height:2px; width:90%; margin: 5px auto; border-width:0; color:red; background-color:red;" class="mb-3"> --}}
        </div>
        
        {{-- @include('admin.elearning.elearning_table') --}}

    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function(){

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        
        $.extend(true, $.fn.dataTable.defaults, {
        order: [[ 1, 'desc' ]],
        pageLength: 100,
        });
        $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    });

    </script>
@endsection
