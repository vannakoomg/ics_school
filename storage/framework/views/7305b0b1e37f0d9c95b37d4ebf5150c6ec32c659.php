
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

            <a class="btn btn-primary" href="<?php echo e(route("admin.student.promote"), false); ?>?student">
                 Student Promote
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
            <table class="table table-bordered table-striped table-hover datatable datatable-User">
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
                        <th class="text-nowrap">
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
                        Course
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
            </table>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
  
 var dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.users.massDestroy'), false); ?>",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).attr('id');
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
  
//   $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

let selectCampus = "<?php echo e(request('campus'), false); ?>";
let role = "<?php echo e(request('role'), false); ?>";
console.log(role);
var table = $('.datatable-User').DataTable({
        buttons: dtButtons, 
       // destroy: true,
        processing: true,
        serverSide: true,
        paging: true,
        bFilter: true,
        // bInfo:false,
        // "ordering": true,
        // oLanguage:{
        //     "sSearch":'Search only[Student ID, English Name]: '
        // },
       // "deferLoading": 0,
        ajax: {
            url:"<?php echo e(route('admin.user.ajaxlist'), false); ?>?campus=" + selectCampus + '&role=' + role,
        },
        cache:false,
        columnDefs: [
            {
                visible: false,
                targets: ((role==3)?9:7)
            },
            {
            orderable: false,
            className: 'select-checkbox align-bottom',
            targets:0
        }, {
            orderable: false,
            searchable: false,
            targets: -1
        }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
        columns: [
            {defaultContent:''},
            {data: 'photo', name : 'photo'},
            {data: 'fullname', name : 'fullname',class:'p-2 text-left align-middle'},
            {data:'email',name:'email'},
            {data:'phone',name:'phone'},
            {data:'roles',name:'roles'},
            {data:'classes',name:'classes'},
            {data:'course_name',name:'course_name'},
            {data:'rfid',name:'rfid'},
            {data:'voice',name:'voice'},
            {data:'action',name:'action'}
        ],
        "fnDrawCallback": function(oSettings){
            $('.datatable-User tbody td').find('form').submit(function(e){
                //e.preventDefault();
                return confirm('<?php echo e(trans('global.areYouSure'), false); ?>');
            })

            $('.btn_play').click(function(){
                $(this).closest('td').find('audio')[0].play();
            });
        }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/users/index.blade.php ENDPATH**/ ?>