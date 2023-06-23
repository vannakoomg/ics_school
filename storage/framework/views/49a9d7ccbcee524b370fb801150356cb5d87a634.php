<p class="mb-1">&nbsp;</p>
       <table border="0" class="table table-sm table-bordered">
           <thead>

           <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Exam Title</th>
               <?php $__currentLoopData = $dayweeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayweek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <th><?php echo e($dayweek, false); ?></th>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
            <th></th>  
           </tr>
           </thead>
           <tbody>
               <?php $__currentLoopData = $examschedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examschedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <tr>
                        <td><?php echo e($examschedule->date_format, false); ?>  </td>
                        <td><?php echo e($examschedule->start_time, false); ?> to <?php echo e($examschedule->end_time, false); ?></td>
                        <td><?php echo e($examschedule->title, false); ?></td>
                        <?php $__currentLoopData = $dayweeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $dayweek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                            <?php if($i==$examschedule->dayweek): ?>
                                <td class="text-center">
                                    <?php $__currentLoopData = $examschedule->class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <div class="p-0 mb-1 bg-success text-white"><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></div>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <div class="p-0 mb-1 bg-primary text-white"><?php echo e($examschedule->course->name ?? '', false); ?></div>
                
                                 </td>
                            <?php else: ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                             
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <a href="<?php echo e(route('admin.examschedule.edit',$examschedule->id), false); ?>" class="bth btn-sm btn-primary">Edit</a>

                            <form action="<?php echo e(route('admin.examschedule.destroy', $examschedule->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
                            </form>

                        </td>
                    </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </tbody>
       </table><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/exam_schedules/exam_table.blade.php ENDPATH**/ ?>