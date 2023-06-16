<div class="table-responsive">
    <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
        <thead>
            <tr>
                <th width="10">

                </th>
                <th>
                    Posted Date
                </th>
                <th>
                    Class
                </th>
                <th>
                    Course
                </th>
                <th class="text-nowrap">
                    Lesson
                </th>
                <th class="text-nowrap">
                    Description
                </th>
                <th>
                    Category
                </th>
                <th class="text-nowrap text-center">
                    Status
                </th>
                
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
           <?php $__currentLoopData = $elearnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $elearning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <tr>
                <td> </td>
                <td>
                    <?php echo e($elearning->created_at->format("d/m/Y"), false); ?>

               </td>
               <td>
                <?php $__currentLoopData = $elearning->class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge badge-pill badge-primary"><?php echo e($class->name, false); ?>-<?php echo e($class->campus, false); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                </td>
                <td>
                    <?php echo e($elearning->course->name ?? '', false); ?>

                </td>
                <td><a href="<?php echo e($elearning->url, false); ?>"><?php echo e($elearning->lesson, false); ?></a></td>
                <td><?php echo e($elearning->description ?? '', false); ?></td>
                <td><?php echo e($elearning->category, false); ?></td>
                <td class="text-left">
                    <?php echo e($elearning->active==1 ? 'Active':'Inactive', false); ?>

                </td>
               
                
                <td class="text-center">
                  
                            <a class="btn btn-xs btn-primary text-nowrap" href="<?php echo e(route('admin.elearning.edit', $elearning->id), false); ?>">
                                <?php echo e(trans('global.edit'), false); ?>

                            </a> 

                

                            <form action="<?php echo e(route('admin.elearning.changestatus', $elearning->id), false); ?>" method="POST" style="display: inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e($elearning->active==1 ? 'Inactive':'Active', false); ?>">
                            </form>
                   
                            <form action="<?php echo e(route('admin.elearning.destroy', $elearning->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
                            </form>
                          

                </td>

            </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div><?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/elearning/elearning_table.blade.php ENDPATH**/ ?>