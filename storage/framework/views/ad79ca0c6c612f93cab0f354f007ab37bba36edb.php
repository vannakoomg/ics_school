    <div class="row">
        
        <div class="col-lg-12">
            <table class="table table-sm table-bordered" id="tbl_timetable">
                <thead class="text-center">
                    <th width="125">Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th width="110px"></th>
                </thead>
                <tbody id="body">
                    <?php $__currentLoopData = $scheduletemplatedetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-nowrap">
                            <?php echo e($detail->time, false); ?>

                        </td>
                        <?php if(!in_array($detail->breaktime,['Study Time'])): ?>
                            <td colspan="<?php echo e(count($days), false); ?>" class="text-center align-middle" style="background-color:<?php echo e(($detail->breaktime=='Break Time')?'#A04E48':'#C9D9EF', false); ?>"><?php echo e($detail->breaktime, false); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.scheduletemplatedetail.edit', $detail->id), false); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <form action="<?php echo e(route('admin.scheduletemplatedetail.delete', $detail->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                    <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
                                </form>
                            </td>
                        <?php else: ?>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>&nbsp;</td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td>
                                <a href="<?php echo e(route('admin.scheduletemplatedetail.edit', $detail->id), false); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <form action="<?php echo e(route('admin.scheduletemplatedetail.delete', $detail->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                    <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
                                </form>
                            </td>
                            
                        <?php endif; ?>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </tbody>
            </table>

        </div>

    </div><?php /**PATH /mnt/hdd/www/school/resources/views/admin/scheduletemplate/schedule.blade.php ENDPATH**/ ?>