

        <form method="POST" action="<?php echo e(route("admin.elearning.create"), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="search" value="search"/>
        <div class="row">
 
          <?php
              //dd(join("|",array_column($classes->toArray(), 'name')));
          ?>

            <div class="col-lg">
                <label class="form-label">Class Filter</label>
                
                <input list="class_filter" class="form-control" name="class_filter"  value="<?php echo e(old('class_filter',$current_filter['class_filter']), false); ?>" placeholder="Search / Select">
                
                <datalist id="class_filter">
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option data-value="<?php echo e($class->id, false); ?>"><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
                      
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </datalist>
            </div>


            <div class="col-lg">
                <label class="form-label">Course Filter</label>
                <input list="course_filter" class="form-control" name="course_filter" pattern="^(<?php echo e(join("|",array_column($courses->toArray(), 'name')), false); ?>)$" value="<?php echo e(old('course_filter',$current_filter['course_filter']), false); ?>" placeholder="Search / Select">
                
                <datalist id="course_filter">
                  <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($course->name, false); ?>">
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </datalist>
            </div>

            <div class="col-lg">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="form-control btn btn-primary">Search...</button>
            </div>

        </div>
        </form><?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/elearning/filter.blade.php ENDPATH**/ ?>