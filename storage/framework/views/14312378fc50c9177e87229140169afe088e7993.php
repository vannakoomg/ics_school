<?php $__env->startSection('styles'); ?>
    <style>
        table.datatable td {
            vertical-align: middle;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_create')): ?>
            <a class="btn btn-success" href="<?php echo e(route("admin.users.create"), false); ?>">
                <?php echo e(trans('global.add'), false); ?> <?php echo e(trans('cruds.user.title_singular'), false); ?>

            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school-setup')): ?>
            <a class="btn btn-success" href="<?php echo e(route("admin.users.create"), false); ?>?teacher">
                <?php echo e(trans('global.add'), false); ?> New Teacher
            </a>
            
            <a class="btn btn-success" href="<?php echo e(route("admin.users.create"), false); ?>?student">
                <?php echo e(trans('global.add'), false); ?> New Student
            </a>

            <a class="btn btn-info" href="<?php echo e(route("admin.users.pickup_report"), false); ?>?student">
                Pickup Repot Card
            </a>

            <?php endif; ?>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        <form name="frmcampus" method="get" action="<?php echo e(route("admin.users.index"), false); ?>" enctype="multipart/form-data">
            <div class="row">
            <div class="col">
                <?php echo e(trans('cruds.user.title_singular'), false); ?> <?php echo e(trans('global.list'), false); ?>

            </div>
            <?php if(in_array(request()->role,[3,4])): ?>
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
            <?php endif; ?>
            </form>
       
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
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
                            <?php echo e((Request()->role==4)?'Student ID':trans('cruds.user.fields.email'), false); ?>

                        </th>
                        <th>
                            <?php echo e('Phone', false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.roles'), false); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.user.fields.class'), false); ?>

                        </th>
                        <th>
                            RFID
                        </th>
                        <th width="30px">
                            Voice
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($user->id, false); ?>">
                            <td class="align-middle">

                            </td>
                            <td>
                                <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                                    <?php echo '<img clas="img-fluid img-thmbnail" src="' . (!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))  . '" style="width:100%;height:auto">'; ?>

                                </div>
                                
                            </td>
                            <td>
                                <?php echo e($user->namekh ?? '', false); ?> <br/>
                                <?php echo e($user->name ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($user->email ?? '', false); ?>

                            </td>
                            <td>
                                <?php echo e($user->phone ?? '', false); ?>

                            </td>
                
                            <td>
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-info"><?php echo e($item->title, false); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td>
                                <?php if($user->roles->contains(3)): ?>
                                    <?php $__currentLoopData = $user->classteacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-success"><?php echo e($class->name, false); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php echo e($user->class->name ?? '', false); ?>

                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $user->rfidcard ? '<i class="fa fa-check" aria-hidden="true"></i>':''; ?>

                            </td>

                            <td>
                                <?php if($user->voice): ?>
                                <input type="button" class="btn btn-sm btn-primary btn_play" value="Play">
                                <audio controls class="btn btn-sm" style="padding:0px;margin:0;display:none";              
                                        <source src="<?php echo e(asset('storage/audio/' . $user->voice), false); ?>" type="audio/mp3">
                                </audio>
                                <?php endif; ?>
                            </td>
                            
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_show')): ?>
                                    <?php if($user->roles->contains(4)): ?>
                                    <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.users.show', ['user'=>$user->id,'role'=> request()->role]), false); ?>">
                                        <?php echo e(trans('Collection Card'), false); ?>

                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_edit')): ?>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.users.edit', $user->id), false); ?>">
                                        <?php echo e(trans('global.edit'), false); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id), false); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
                                        <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete'), false); ?>">
                                    </form>
                                <?php endif; ?>

                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.users.massDestroy'), false); ?>",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('<?php echo e(trans('global.datatables.zero_selected'), false); ?>')

        return
      }

      if (confirm('<?php echo e(trans('global.areYouSure'), false); ?>')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
<?php endif; ?>

  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 3, 'desc' ]],
    pageLength: 50,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    $('.btn_play').click(function(){
        $(this).closest('td').find('audio')[0].play();
    });
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /mnt/disk3/www/school/resources/views/admin/users/index.blade.php ENDPATH**/ ?>