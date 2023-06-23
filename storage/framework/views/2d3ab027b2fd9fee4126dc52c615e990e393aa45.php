    <div class="row">
        <div class="col-2" id="teacher">
            
            <ul class="list-group">
                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item border border-muted list-group-item-info btn_teacher" data-value="<?php echo e($id, false); ?>">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        <?php echo e($teacher, false); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="col-lg-8">
            <table class="table table-sm table-bordered khmer_os" id="tbl_timetable" style="border-color:#000">
                <thead>
                    <tr class="text-center">
                    <th>Time</th>
                    <th width="13%">Monday</th>
                    <th width="13%">Tuesday</th>
                    <th width="13%">Wednesday</th>
                    <th width="13%">Thursday</th>
                    <th width="13%">Friday</th>
                    <th width="13%">Saturday</th>
                    </tr>
                </thead>
                <tbody id="body">
                    <?php
                        $pp=0;
                    ?>
                    <?php $__currentLoopData = $scheduletemplatedetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timetable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $pp++;
                        $days = ['monday','tuesday','wednesday','thursday','friday','saturday']; 

                        $data=[];

                        foreach ($days as $day) {
                                $data[$day] = [
                                'course' => $timetable->getcourse($current_filter,$day),
                                'course_color' => $timetable->getcoursecolor($current_filter,$day),
                                'teacher' => $timetable->getteacher($current_filter,$day),
                                'tr_id' => $timetable->getcurrentid($current_filter),
                            ];     
                        }
                
                    ?>
                    <tr>
                        <td class="text-nowrap align-middle">
				<?php echo e($timetable->time, false); ?>       
			</td>
                        <?php if(strtolower($timetable->breaktime) != 'study time'): ?>
                            <td colspan="<?php echo e(count($days), false); ?>" class="text-center align-middle 
                            <?php if($pp>1): ?>
                                <?php if(strtolower($cuurent_class->level_type)=='primary'): ?>
                                        breaktime-bg-primary breaktime-color-primary
                                <?php elseif(strtolower($cuurent_class->level_type)=='secondary'): ?>
                                        breaktime-bg-secondary breaktime-color-secondary
                                <?php elseif(strtolower($cuurent_class->level_type)=='kindergarten'): ?>
                                        breaktime-bg-kindergarten breaktime-color-kindergarten
                                <?php endif; ?>
                            <?php endif; ?>

                            "><?php echo e($timetable->breaktime, false); ?></td>
                           
                        <?php else: ?>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center" style="background-color:<?php echo e($data[$day]['course_color'], false); ?>" data-countteacher="<?php echo e(empty($data[$day]['teacher'])?0:1, false); ?>" data-countcourse="<?php echo e(empty($data[$day]['course'])?0:1, false); ?>" data-url="<?php echo e(route('admin.timetable.updatetimetable',$timetable->id), false); ?>" data-urlremove="<?php echo e(route('admin.timetable.removetimetable',$timetable->id), false); ?>" data-column='<?php echo e($day, false); ?>' data-class_id='<?php echo e($current_filter['class_id'], false); ?>' data-template_id='<?php echo e($current_filter['template_id'], false); ?>' data-trid='<?php echo e($data[$day]['tr_id'], false); ?>'>
                                    <?php if(!empty($data[$day]['course'])): ?>
                                        <div class="btn_course ui-draggable ui-draggable-handle" data-value="6" style="z-index: 6; background-color:transparent"><strong><?php echo e($data[$day]['course'], false); ?></strong></div>
                                    <?php endif; ?>

                                    <?php if(!empty($data[$day]['teacher'])): ?>  
                                        <div class="align-bottom  btn_teacher ui-draggable ui-draggable-handle" data-value="6" style="z-index: 6;background-color:transparent"><?php echo e($data[$day]['teacher'], false); ?></div>
                                    <?php endif; ?>    
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            
                        <?php endif; ?>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </tbody>
            </table>

                    
        </div>

        <div class="col-2" id="course">
            
            <ul class="list-group">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                    <li class="list-group-item border border-muted btn_course" data-color="<?php echo e($course->color, false); ?>" data-value="<?php echo e($course->id, false); ?>" style="background-color:<?php echo e($course->color ?? '#f1f1f1', false); ?>">
                        <i class="fa-fw fas fa-expand-arrows-alt nav-icon"></i>
                        <span class="khmer_os"><?php echo e($course->name, false); ?></span></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

    </div>
<?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/lessons/calendar.blade.php ENDPATH**/ ?>