

        <form method="POST" action="<?php echo e(route("admin.examschedule.create"), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="search" value="search"/>
        <div class="row">
            <div class="col-lg">
                <label class="form-label">Exam Title Filter</label>
                <input list="exam_title" class="form-control" name="exam_title" value="<?php echo e(old('exam_title', $current_filter['exam_title']), false); ?>" placeholder="Search / Select">
                
                <datalist id="exam_title">
                    <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($title->title, false); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </datalist>
            </div>

            <div class="col-lg">
                <label class="form-label">Class Filter</label>
                
                <input list="class_filter" class="form-control" name="class_filter" value="<?php echo e(old('class_filter',$current_filter['class_filter']), false); ?>" placeholder="Search / Select">
                
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
        </form><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/exam_schedules/filter.blade.php ENDPATH**/ ?>