

<?php $__env->startSection('styles'); ?>
    <style>

    </style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<Form  method="POST" action="<?php echo e(route("admin.users.pickup_report"), false); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg">Campus
           
            <a href="<?php echo e(route('admin.users.pickup_report'), false); ?>?student&campus=MC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='MC')?'active':'', false); ?>' data-value='mc'>MC</a>
            <a href="<?php echo e(route('admin.users.pickup_report'), false); ?>?student&campus=CC" class='btn btn-sm btn-info campus <?php echo e(($selected_campus->campus=='CC')?'active':'', false); ?>' data-value='cc'>CC</a>
            </div>
            <div class="col-lg text-center">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                       
                       <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>

            </div>
            
            <div class="col-lg text-right">
            <a class='btn btn-secondary' id='btn_notification' href="<?php echo e(route("admin.users.index"), false); ?>?role=4">Back to Student List</a>
           </div>
         </div>
        
    </div>

    <div class="card-body">
      
        <div class="form-group">
            <?php
                $other=false;   
            ?>
            <input type="hidden" name="campus" value="<?php echo e(request()->input('campus') ?? 'MC', false); ?>"/>
            <div class="row">
                <div class="col-1">
             <label for="class_list">Class: </label>
                </div>
             <div class="col-11">
             <select name="class" class="select2 custom-select" onchange='window.location="<?php echo e(route('admin.users.pickup_report', ['campus'=> $selected_campus->campus]), false); ?>" + "&class=" + this.value ;'>
             <?php $__currentLoopData = $schoolClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $schoolClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <option value="<?php echo e($schoolClass->id, false); ?>" <?php echo e(($schoolClass->id==$selected_class->id)?'selected':'', false); ?> ><?php echo e($schoolClass->name, false); ?></option>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </select>
                </div>
            </div>
            
          </div>

          <p>&nbsp;</p>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Student ID
                        </th>
                        <th>
                            <?php echo e(trans('cruds.schoolClass.fields.name'), false); ?>

                        </th>
                        <th>
                            Campus
                        </th>
                        <th>
                            Class
                        </th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $student_status = $student->guardian1;
                    ?>
                        <tr data-entry-id="<?php echo e($schoolClass->id, false); ?>">
                            <td>
                                <input type="hidden" name="student_id[]" value="<?php echo e($student->id, false); ?>">
                                
                                <?php if(!empty($student_status)): ?>
                                     <i class="fas fa-calendar-check"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($student->email ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($student->name ?? '', false); ?>

                            </td>
                              <td>
                                <?php echo e($student->class->campus ?? '', false); ?>

                            </td>

                            <td>
                                <?php echo e($student->class->name ?? '', false); ?>

                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button class="btn btn-primary float-left m-2" type="submit" name="btn_preview">
                Preview
            </button>
            <button class="btn btn-info float-right m-2" type="submit" name="btn_pdf_front">
                Print (Front side) Pdf
            </button>
            <button class="btn btn-info float-right m-2" type="submit" name="btn_pdf_back">
                Print (Back side) Pdf
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/users/pickup-card.blade.php ENDPATH**/ ?>