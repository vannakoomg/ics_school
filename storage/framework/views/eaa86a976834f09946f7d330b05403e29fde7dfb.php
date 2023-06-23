

<?php $__env->startSection('styles'); ?>
    <style>

    </style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<Form  method="POST" action="<?php echo e(route("admin.attendance.generate"), false); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg">Campus
           
            <a href="<?php echo e(route('admin.attendance.generate'), false); ?>?campus=MC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='MC')?'active':'', false); ?>' data-value='mc'>MC</a>
            <a href="<?php echo e(route('admin.attendance.generate'), false); ?>?campus=CC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='CC')?'active':'', false); ?>' data-value='cc'>CC</a>
            </div>
            <div class="col-lg text-center">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                       <input type='text' class="form-control date" name="txt_date" readonly value="<?php echo e(date('d/m/Y'), false); ?>" required />
                       <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>

            </div>
            
            <div class="col-lg text-right">
            <a class='btn btn-secondary' id='btn_notification' href="<?php echo e(route("admin.attendance.index"), false); ?>">Back to List</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">

          <h4 class="text-center">Generate Attendance for all students at campus <?php echo e($selected_campus->campus, false); ?></h4>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Campus
                        </th>
                        <th>
                            Class
                        </th>
                        <th>
                            Attendance
                        </th>
                        <th>
                            Student Absent
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $schoolClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $schoolClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                        <tr data-entry-id="<?php echo e($schoolClass->id, false); ?>">
                            <td>
                                
                                
                                
                            </td>
                            <td>
                                <?php echo e($schoolClass->campus ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($schoolClass->name ?? '', false); ?>

                                <input type="hidden" name="class_id[]" value="<?php echo e($schoolClass->id, false); ?>">
                            </td>

                            <td>
                                <div  class="btn btn-sm btn-primary text-left">
                                    Total <span class="badge badge-light"><?php echo e(($schoolClass->total ?? 0), false); ?></span>
                                    
                                </div>
                                <div  class="btn btn-sm btn-success text-left">
                                    Present <span class="badge badge-dark"><?php echo e(($schoolClass->total ?? 0) - ($schoolClass->absent_excused ?? 0) - ($schoolClass->absent_unexcused ?? 0), false); ?>  </span>
                                   <?php
                                        $student_present=$schoolClass->getStudentAttendances('Presentonly',date('Y-m-d'));
                                   ?>
                                    <input type="hidden" name="present[]" value="<?php echo e(is_array($student_present)?join(",",$student_present):'', false); ?>">
                                </div>

                                <div  class="btn btn-sm btn-warning text-left">
                                    Absent & Excused <span class="badge badge-dark"><?php echo e($schoolClass->absent_excused ?? 0, false); ?></span>
                                    <?php
                                    $student_absent_excused=$schoolClass->getStudentAttendances('Absent & Excused',date('Y-m-d'));
                                   ?>
                                    <input type="hidden" name="absent_excused[]" value="<?php echo e(is_array($student_absent_excused)?join(",",$student_absent_excused):'', false); ?>">
                                </div>

                                <div  class="btn btn-sm btn-secondary text-left">
                                    Absent & Unexcused <span class="badge badge-dark"><?php echo e($schoolClass->absent_unexcused ?? 0, false); ?></span>
                                    <?php
                                    $student_absent_unexcused=$schoolClass->getStudentAttendances('Absent & Unexcused',date('Y-m-d'));
                                   ?>
                                    <input type="hidden" name="absent_unexcused[]" value="<?php echo e(is_array($student_absent_unexcused)?join(",",$student_absent_unexcused):'', false); ?>">
                                </div>
                            </td>
                            <td>
                                <?php $__currentLoopData = $schoolClass->getAbsents('Absent & Excused'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-warning"><?php echo e($student->name, false); ?></span></br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $schoolClass->getAbsents('Absent & Unexcused'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-secondary"><?php echo e($student->name, false); ?></span></br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button class="btn btn-danger pull-right" type="submit">
                Generate & <?php echo e(trans('global.save'), false); ?> 
            </button>
        </div>
    </div>
</div>
</Form>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
     
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/attendance/generate.blade.php ENDPATH**/ ?>