

<?php $__env->startSection('content'); ?>
<?php

if(request()->has('cur_year'))
    $year = request()->input('cur_year');
else
    $year = date('Y');

 if(request()->has('cur_month'))
    $month = date('m', strtotime("$year-" . request()->input('cur_month') . "-1"));
 else
    $month = date('m');

 $prev = (int) $month -1;
 $prev_year = $year;
 if($prev<=0){
    $prev=12;
    $prev_year = $prev_year -1;
 }

 $next =  (int) $month +1;
 $next_year = $year;
 if($next > 12){
    $next=1;
    $next_year = $next_year + 1;
 }

    $strtime = strtotime("$year-$month-1");

    $cur_monthname = date("F",$strtime);

    $dayofmonth= date('t' , $strtime);

    $days = ['Su','Mo','Tu','We','Th','Fr','Sa'];

 ?>

<div class="card">
    <div class="card-header">
        <div class="clearfix">
            <div class="float-left">Campus
           
                <a href="<?php echo e(route('admin.attendance.index'), false); ?>?cur_year=<?php echo e($year, false); ?>&cur_month=<?php echo e($month, false); ?>&campus=MC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='MC')?'active':'', false); ?>' data-value='mc'>MC</a>
                <a href="<?php echo e(route('admin.attendance.index'), false); ?>?cur_year=<?php echo e($year, false); ?>&cur_month=<?php echo e($month, false); ?>&campus=CC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='CC')?'active':'', false); ?>' data-value='cc'>CC</a>
            </div>

            <div class="float-right">
                <a class='btn btn-primary' id='btn_notification' href="<?php echo e(route("admin.attendance.generate"), false); ?>">Generate Attendance for All Student</a>
                <a class='btn btn-success' id='btn_notification' href="<?php echo e(route("admin.attendance.create"), false); ?>">Register Attendance</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">

     <div class="row">   
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <?php
                $other=false;   
            ?>
            <label for="class_list">Classes: </label>
            <select name="lst_class" class="select2" onchange='window.location="<?php echo e(route('admin.attendance.index', ['cur_month' => $month,'cur_year'=> $year, 'campus'=> $selected_campus->campus]), false); ?>" + "&class=" + this.value ;'>
            <?php $__currentLoopData = $schoolClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $schoolClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($schoolClass->id, false); ?>" <?php echo e(($schoolClass->id==$selected_class->id)?'selected':'', false); ?> ><?php echo e($schoolClass->name, false); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
          </div>
     </div> 
    
     <div class="row">
        <div class="col-lg p-2">
            <a href="<?php echo e(route('admin.attendance.index'), false); ?>?cur_year=<?php echo e($prev_year, false); ?>&cur_month=<?php echo e($prev, false); ?>&campus=<?php echo e($selected_campus->campus, false); ?>&class=<?php echo e($selected_class->id, false); ?>" class="btn btn-primary btn-arrow-left">Prev Month</a>
        </div>

        <div class="col-lg p-2 text-center">
            <h2 class="text-primary"><?php echo e($cur_monthname, false); ?></h2>
        </div>

        <div class="col-lg p-2 text-right">
            <a href="<?php echo e(route('admin.attendance.index'), false); ?>?cur_year=<?php echo e($next_year, false); ?>&cur_month=<?php echo e($next, false); ?>&campus=<?php echo e($selected_campus->campus, false); ?>&class=<?php echo e($selected_class->id, false); ?>" class="btn btn-primary btn-arrow-left">Next Month</a>
        </div>
    
    </div>
    
     <?php
         
     
    echo '<table class="table table-sm table-bordered">
            <tr>
                <td rowspan=2>Student ID</td>  
                <td rowspan=2>Student Name</td>';    
            $i=0;
            foreach($dateRanges as $date){
                echo '<td>'  . ++$i .  '</td>';
            }  
    echo '</tr><tr>';
        for($i=1;$i<=$dayofmonth;$i++){
                $date="$year-$month-$i";
                $day_of_week = date('w',strtotime($date));
                echo '<td>'  .  $days[$day_of_week] .  '</td>';
            }  
    echo '</tr>'; 
    
    foreach($students as $student){
        echo '<tr>';
            echo '<td>' . $student->email . '</td>';
            echo '<td>' . $student->name . '</td>';
            foreach($dateRanges as $date){
                echo '<td class="text-center">' .  ((array_key_exists($student->id, $attendances) && array_key_exists($date, $attendances[$student->id])) ? $attendances[$student->id][$date] :'')  .  '</td>';
            }
            // for($i=1;$i<=$dayofmonth;$i++){
            //     //$date="$year-$month-$i";
            //     $date = sprintf("%04d-%02d-%02d",$year,$month,$i);
            //  //   dd($date);
            //     $status=$student->getAttendance($date);
                
            //     switch(strtolower($status)){
            //         case 'present':
            //             $symbold='<i class="fas fa-check-circle text-primary"></i>';
            //             break;
            //         case 'absent & excused':
            //             $symbold='<i class="fas fa-times-circle text-warning"></i>';
            //             break;    
            //         case 'absent & unexcused':
            //             $symbold='<i class="fas fa-times-circle text-danger"></i>';
            //             break;     
            //         default:
            //             $symbold ='';      

            //     }
            //     echo '<td class="text-center">' . $symbold  .  '</td>';
            // }


        echo '</tr>';
    }
    
    echo '</table>';     
     ?>    
     
  
        <div class="col-12 p-2 bg-light">
            Present: <i class="fas fa-check-circle text-primary"></i>, Absent & Excused: <i class="fas fa-times-circle text-warning"></i>, Absent & Unexcused: <i class="fas fa-times-circle text-danger"></i> 
        </div>
 
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
 
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/attendance/index.blade.php ENDPATH**/ ?>