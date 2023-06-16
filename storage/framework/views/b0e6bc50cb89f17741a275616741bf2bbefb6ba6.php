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
        E-Learning Management (Edit Form)
    </div>

    <div class="card-body">

        <p class="text-right" style="margin-bottom:0">
            <a href="#mission" class="btn btn-outline-primary btn_addform" data-toggle="collapse" data-target="#addform" aria-expanded="true"><i class="fa fa-angle-double-down text-lg-c  enter"></i> Edit Lesson</a>
        </p>
        <div class="collapse show" id="addform">

        <form method="POST" action="<?php echo e(route("admin.elearning.update",$elearning->id), false); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('put'); ?>
            <div class="row">
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="class_id" class="required">Class</label>
                        <select name="class_id[]" class="select2 custom_form" required multiple>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id, false); ?>" <?php echo e(old('class_id') == $class->id ? 'selected' : '', false); ?> <?php echo e(($elearning->class->contains($class->id)) ? 'selected' : '', false); ?>><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                      </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="required">Course</label>
                        <select name="course_id" class="select2 form-control" required>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id, false); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : '', false); ?> <?php echo e(($course->id==$elearning->course_id) ? 'selected' : '', false); ?>><?php echo e($course->name, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                      </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="url" class="required">Category</label>
                        <div class="row">
                        <input type="checkbox" data-width="130" name="category" data-toggle="toggle" <?php echo e($elearning->category=='Video'?'checked':'', false); ?> class="text-nowrap" data-onstyle="primary" data-offstyle="secondary" data-on="<i class='fa fa-play'></i> Video" data-off="<i class='fa fa-book'></i> Document">
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="lesson" class="required">Lesson</label>
                        <input type="text" class="form-control" name="lesson" aria-describedby="emailHelp" placeholder="Lesson Title" value="<?php echo e(old('lesson', $elearning->lesson), false); ?>" required>
                        
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="description" class="required">Description</label>
                        <input  type="text" class="form-control" name="description" aria-describedby="emailHelp" placeholder="Lesson Description" value="<?php echo e(old('description', $elearning->description), false); ?>" required>
                        
                      </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="url" class="required">URL/Link</label>
                        <input  type="text" class="form-control" name="url" aria-describedby="emailHelp" placeholder="Video or Pdf Link" value="<?php echo e(old('url', $elearning->url), false); ?>" required>
                        
                      </div>
                </div>
                

                <div class="col-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">&nbsp;</label>
                        <div class="row">
                        <button name="btn_save"  type="submit" class="btn btn-primary text-nowrap"> &nbsp;Save&nbsp;</button>
                        </div>
                        
                      </div>
                </div>
            </div>
        </form>
        
        </div>
        
        

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(document).ready(function(){

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        
        $.extend(true, $.fn.dataTable.defaults, {
        order: [[ 1, 'desc' ]],
        pageLength: 100,
        });
        $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/school/resources/views/admin/elearning/edit.blade.php ENDPATH**/ ?>