<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Calendar
                </div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status'), false); ?>

                        </div>
                    <?php endif; ?>

                    <table class="table table-bordered">
                        <thead>
                            <th width="125">Time</th>
                            <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($day, false); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $calendarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time => $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($time, false); ?>

                                    </td>
                                    <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(is_array($value)): ?>
                                            <td rowspan="<?php echo e($value['rowspan'], false); ?>" class="align-middle text-center" style="background-color:#f0f0f0">
                                                <?php echo e($value['class_name'], false); ?><br>
                                                Teacher: <?php echo e($value['teacher_name'], false); ?>

                                            </td>
                                        <?php elseif($value === 1): ?>
                                            <td></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/disk2/www/school/resources/views/admin/calendar.blade.php ENDPATH**/ ?>