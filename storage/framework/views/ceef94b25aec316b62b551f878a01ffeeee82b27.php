

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        Exam Schedule Management
    </div>

    <div class="card-body">

        <p class="text-right" style="margin-bottom:0">
            <a href="#mission" class="btn btn-outline-primary btn_addform" data-toggle="collapse" data-target="#addform" aria-expanded="true"><i class="fa fa-angle-double-down text-lg-center"></i> Add Exam Schedule</a>
        </p>
        <div class="collapse" id="addform">

        <form method="POST" action="<?php echo e(route("admin.examschedule.store"), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Date</label>
                        <input type="text" class="form-control date" name="date" aria-describedby="emailHelp" placeholder="Date" value="<?php echo e(old('date'), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Start Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="start_time" aria-describedby="emailHelp" placeholder="" value="<?php echo e(old('start_time'), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">End Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="end_time" aria-describedby="emailHelp" placeholder="" value="<?php echo e(old('end_time'), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Title</label>
                        <input list="exam_title" type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Exam Title" value="<?php echo e(old('title'), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom-form" required multiple>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id, false); ?>" <?php echo e(old('class_id') == $class->id ? 'selected' : '', false); ?> <?php echo e(($class->id==request()->class_id) ? 'selected' : '', false); ?>><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="form-control" required>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id, false); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : '', false); ?> <?php echo e(($course->id==request()->course_id) ? 'selected' : '', false); ?>><?php echo e($course->name, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

        <?php echo $__env->make('admin.exam_schedules.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo $__env->make('admin.exam_schedules.exam_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/exam_schedules/create.blade.php ENDPATH**/ ?>