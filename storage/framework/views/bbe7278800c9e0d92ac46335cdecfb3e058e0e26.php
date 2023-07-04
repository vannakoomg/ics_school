
<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <?php echo e(trans('global.edit'), false); ?> <?php echo e(trans('cruds.schoolClass.title_singular'), false); ?>

    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route("admin.school-classes.update", [$schoolClass->id]), false); ?>" enctype="multipart/form-data">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-4">

            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('cruds.schoolClass.fields.name'), false); ?></label>
                <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text" name="name" id="name" value="<?php echo e(old('name', $schoolClass->name), false); ?>" required>
                <?php if($errors->has('name')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('name'), false); ?>

                    </div>
                <?php endif; ?>
                <span class="help-block"><?php echo e(trans('cruds.schoolClass.fields.name_helper'), false); ?></span>
            </div>
                </div>
                <div class="col-4">
            <div class="form-group">
                <label class="required" for="name"><?php echo e(trans('Campus'), false); ?></label>
             
                <select name='campus' class="custom-select" required>
                    <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($campus, false); ?>" <?php echo e(($campus==$schoolClass->campus)?'selected':'', false); ?>><?php echo e($campus, false); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
         
                <?php if($errors->has('campus')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('campus'), false); ?>

                    </div>
                <?php endif; ?>

                <span class="help-block"><?php echo e('', false); ?></span>
                
            </div>
                </div>
                <div class="col-4">
            <div class="form-group">
                <label class="" for="roomno"><?php echo e(trans('Room No'), false); ?></label>
                <input type="text" class="form-control" name="roomno" id="roomno" value="<?php echo e(old('roomno', $schoolClass->roomno), false); ?>"/>
                <span class="help-block"><?php echo e('', false); ?></span>
            </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">

            <div class="form-group">
            <label class="" for="homeroom_id"><?php echo e(trans('Homeroom'), false); ?></label>
            <select name='homeroom_id' class="custom-select">
                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id, false); ?>" <?php echo e(($id==$schoolClass->homeroom_id)?'selected':'', false); ?>><?php echo e($teacher, false); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
                <span class="help-block"></span>
            </div>
            </div>
            
            <div class="col-4">
            <div class="form-group">
                <label class="" for="khteacher_id"><?php echo e(trans('Khmer Teacher'), false); ?></label>
                <select name='khteacher_id' class="custom-select">
                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id, false); ?>" <?php echo e(($id==$schoolClass->khteacher_id)?'selected':'', false); ?>><?php echo e($teacher, false); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="help-block"><?php echo e('', false); ?></span>
            </div>
            </div>
                
            <div class="col-4">
            <div class="form-group">
                <label class="" for="teacheraide_id"><?php echo e(trans('Teacher Aide'), false); ?></label>
                <select name='teacheraide_id' class="custom-select">
                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id, false); ?>" <?php echo e(($id==$schoolClass->teacheraide_id)?'selected':'', false); ?>><?php echo e($teacher, false); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="help-block"><?php echo e('', false); ?></span>
            </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="" for="template_id"><?php echo e(trans('Schedule Template'), false); ?></label>
                        <select name='template_id[]' class="custom-select select2" multiple data-maximum-selection-length="2">
                            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id, false); ?>" <?php echo e((in_array($id, old('template_id', [])) || $schoolClass->schedule_template->contains($id))  ? 'selected' : '', false); ?>><?php echo e($template, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="" for="template_id"><?php echo e(trans('Group'), false); ?></label>
                        <select name='level_type' class="custom-select select2">
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group, false); ?>" <?php echo e($group==$schoolClass->level_type ? 'selected':'', false); ?>><?php echo e($group, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
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

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(document).ready(function(){

        $('select[name="campus"]').on("change", function(e){
            
           // window.location= "<?php echo e(route("admin.school-classes.edit",[$schoolClass->id]), false); ?>&campus=" + $(this).val();

           var id = $(this).val();

         // Empty the dropdown
         $('select[name="homeroom_id"]').find('option').not(':first').remove();
         $('select[name="khteacher_id"]').find('option').not(':first').remove();
         $('select[name="teacheraide_id"]').find('option').not(':first').remove();
         
         // AJAX request 
         $.ajax({
           url: "<?php echo e(route('admin.getteacher',['campus']), false); ?>".replace('campus',id),
           type: 'get',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
             }

             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var id = response['data'][i].id;
                 var name = response['data'][i].name;

                 var option = "<option value='"+id+"'>"+name+"</option>"; 

                 $('select[name="homeroom_id"]').append(option); 
                 $('select[name="khteacher_id"]').append(option);
                 $('select[name="teacheraide_id"]').append(option);  
        
               }
             }

           }
        });
        

        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/schoolClasses/edit.blade.php ENDPATH**/ ?>