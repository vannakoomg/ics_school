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
        Edit Exam Schedule 
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("admin.examschedule.update",$examschedule->id), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
      
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Date</label>
                        <input type="text" class="form-control date" name="date" aria-describedby="emailHelp" placeholder="Date" value="<?php echo e(old('date', $examschedule->date_format), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Start Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="start_time" aria-describedby="emailHelp" placeholder="Start Time" value="<?php echo e(old('start_time', $examschedule->start_time), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">End Time</label>
                        <input type="text" class="form-control lesson-timepicker" name="end_time" aria-describedby="emailHelp" placeholder="End Time" value="<?php echo e(old('end_time', $examschedule->end_time), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Title</label>
                        <input list="exam_title" type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Exam Title" value="<?php echo e(old('title', $examschedule->title), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom-form" required multiple>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id, false); ?>" <?php echo e(old('class_id') == $class->id ? 'selected' : '', false); ?> <?php echo e(($examschedule->class->contains($class->id)) ? 'selected' : '', false); ?>><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                      </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="form-control" required>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id, false); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : '', false); ?> <?php echo e(($course->id==$examschedule->course_id) ? 'selected' : '', false); ?>><?php echo e($course->name, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/hdd/www/school/resources/views/admin/exam_schedules/edit.blade.php ENDPATH**/ ?>