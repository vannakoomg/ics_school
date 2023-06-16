<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.edit'), false); ?> <?php echo e(trans('cruds.lesson.title_singular'), false); ?>

    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("admin.timetable.update", [$timetable->id]), false); ?>" enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="required" for="class_id"><?php echo e(trans('cruds.lesson.fields.class'), false); ?></label>
                
                <label class="form-control"><?php echo e($classes[$timetable->class_id], false); ?></label>
                <input type="hidden" name="class_id" value="<?php echo e($timetable->class_id, false); ?>"/>
                <?php if($errors->has('class')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('class'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.lesson.fields.class_helper'), false); ?></span>
            </div>
    
            <div class="form-group">
                <label class="required" for="start_time"><?php echo e(trans('cruds.lesson.fields.start_time'), false); ?></label>
                <input class="form-control lesson-timepicker <?php echo e($errors->has('start_time') ? 'is-invalid' : '', false); ?>" type="text" name="start_time" id="start_time" value="<?php echo e(old('start_time', $timetable->start_time), false); ?>" required>
                <?php if($errors->has('start_time')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('start_time'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.lesson.fields.start_time_helper'), false); ?></span>
            </div>
            <div class="form-group">
                <label class="required" for="end_time"><?php echo e(trans('cruds.lesson.fields.end_time'), false); ?></label>
                <input class="form-control lesson-timepicker <?php echo e($errors->has('end_time') ? 'is-invalid' : '', false); ?>" type="text" name="end_time" id="end_time" value="<?php echo e(old('end_time', $timetable->end_time), false); ?>" required>
                <?php if($errors->has('end_time')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('end_time'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.lesson.fields.end_time_helper'), false); ?></span>
            </div>
                <div class="form-group">
                  <?php
                    $breaktimes=['Study Time'=>'','Break time'=>'Break Time','Lunch Break'=> 'Lunch Break'];   
                  ?>
                    <label class="" for="start_time">Break Time</label>
                  
                    <select name="breaktime" class="custom-select">
                         <?php $__currentLoopData = $breaktimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($value, false); ?>" <?php echo e($timetable->breaktime == $value ? 'selected' : '', false); ?>><?php echo e($key, false); ?></option>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                          
                    </select>
                </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    <?php echo e(trans('global.save'), false); ?>

                </button>
            </div>
        </form>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/lessons/edit.blade.php ENDPATH**/ ?>