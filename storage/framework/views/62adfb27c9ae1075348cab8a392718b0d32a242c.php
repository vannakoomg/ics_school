<?php $__env->startSection('styles'); ?>
    <style>
        table.datatable td {
            vertical-align: middle;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div style="margin-bottom: 10px;" class="row">
    
    </div>

<div class="card">
    <form name="frmcampus" method="get" action="<?php echo e(route("admin.student.promote"), false); ?>" enctype="multipart/form-data">
    <div class="card-header">
        
            <div class="row">
            <div class="col">
               Student Promote
            </div>
            
            <div class="col">
                <div class="form-group row">
                    <label class="required col-sm-3 col-form-label" for="class_id">Campus</label>
                    <div class="col-sm-9">
                          <select  class="custom-select <?php echo e($errors->has('campus') ? 'is-invalid' : '', false); ?>" name="campus" id="campus" onchange="document.forms['frmcampus'].submit()">
                              <?php $__currentLoopData = $campus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($key, false); ?>" <?php echo e(old('campus') == $key ? 'selected' : '', false); ?> <?php echo e($key==$current_filter['campus']?'selected':'', false); ?>><?php echo e($key, false); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                    </div>      
                  </div>
                </div>
            </div>
            <input type="hidden" name="role" value="<?php echo e(request()->role ?? '', false); ?>"/>
            
            
       
    </div>

 
    <div class="card-body">

        <div class="row">
            <div class="col-6">
                <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Current Class</label>
                <div class=" col-sm-8">
                        <select class="custom-select" name="cur_class" id="cur_class" onchange="document.forms['frmcampus'].submit()">
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($id, false); ?>" <?php echo e($id==request()->input('cur_class') ? 'selected':'', false); ?>><?php echo e($class, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                        </select>
                </div>
                </div>
                <div class="table-responsive">
                   
                    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead>
                            <tr>
                                <th width="10">
                                    <input type="checkbox" value="1" id='checkall'>
                                </th>
                                <th>
                                    <?php echo e('Photo', false); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('cruds.user.fields.name'), false); ?>

                                </th>
                                <th>
                                    <?php echo e('Student ID', false); ?>

                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                <?php $__currentLoopData = $cur_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" value="<?php echo e($user->id, false); ?>" name="chk[]"/></td>
                                        <td>
                                        <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                                            <?php echo '<img clas="img-fluid img-thmbnail" src="' . (!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))  . '" style="width:100%;height:auto">'; ?>

                                        </div>
                                        </td>
                                        <td><?php echo e($user->name ?? '', false); ?><br><?php echo e($user->namekh, false); ?></td>
                                        <td><?php echo e($user->email, false); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        
                    </table>
                </div>
            </form>
            </div>

            <div class="col-6">
    
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Promote Class</label>
                    <div class=" col-sm-6">
                        <select class="custom-select" name="new_class" id='new_class' onchange="document.forms['frmcampus'].submit()">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($id, false); ?>" <?php echo e($id==request()->input('new_class') ? 'selected':'', false); ?>><?php echo e($class, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                    </select>

                  
                    </div>
                    <div class=" col-sm-2">
                        <input type="submit" class="btn btn-primary" value="Promote" name="btn_promote"/>
                    </div>
                    </div>

                <div class="table-responsive">
                    

                    <table class=" table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th width="10">
                                    
                                </th>
                                <th>
                                    <?php echo e('Photo', false); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('cruds.user.fields.name'), false); ?>

                                </th>
                                <th>
                                    <?php echo e('Student ID', false); ?>

                                </th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $new_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                                            <?php echo '<img clas="img-fluid img-thmbnail" src="' . (!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))  . '" style="width:100%;height:auto">'; ?>

                                        </div>
                                    </td>
                                    <td><?php echo e($user->name ?? '', false); ?><br><?php echo e($user->namekh, false); ?></td>
                                    <td><?php echo e($user->email, false); ?></td>

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
<script>
    $(function () {
  


  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 3, 'desc' ]],
    pageLength: 50,
    searching: false, paging: false, info: false,
    buttons:[],
    select: {
        style:    'multi',
        selector: 'td:first-child'
    },
    });

  //$('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.btn_play').click(function(){
        $(this).closest('td').find('audio')[0].play();
    });


    $('#checkall').click(function(){
       
        if($(this).is(':checked'))
            $('.datatable-User input:checkbox').prop('checked',true);
        else
            $('.datatable-User input:checkbox').prop('checked',false);
    });

    $('form').submit(function () {

// Get the Login Name value and trim it
        
        if ($('#cur_class').val() == '' || $('#new_class').val()=='') {
            alert('Current Class and New Class are required.');
            return false;
        }
      // console.log($('.datatable-User input:checkbox:checked').length);
        if($('.datatable-User input:checkbox:checked').length==0){
            alert('Checkbox required select at less 1.');
            return false;
        }

        if(!confirm('Are you sure to promote ' + $('.datatable-User input:checkbox:checked').length + ' selected student?'))
            return false;

});


})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/laravel/school/resources/views/admin/users/promote.blade.php ENDPATH**/ ?>