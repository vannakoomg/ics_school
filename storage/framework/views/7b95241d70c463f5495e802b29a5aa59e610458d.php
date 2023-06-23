

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/xzoom.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('css/magnific-popup.css'), false); ?>" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    <style>
        .khmer_os {
            font-family: 'Noto Sans Khmer', sans-serif;
            font-size:130%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
    <form name="frmcampus" method="get" action="<?php echo e(route("admin.homework.index"), false); ?>" enctype="multipart/form-data">
        <div class="row">

        <div class="col">
            <h3>Assignment <?php echo e(trans('global.list'), false); ?></h3>
        </div>
        </div>
        <div class="row">
            <div class="col text-right">
                <div class="form-group row">
                    <label class=" col col-form-label" for="filter_status">Status</label>
                    <div class="col">
                          <select  class="custom-select" name="filter_status" id="filter_status" onchange="document.forms['frmcampus'].submit()">
                              <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($status, false); ?>" <?php echo e(old('filter_status') == $status ? 'selected' : '', false); ?> <?php echo e($status==$current_filter['status']?'selected':'', false); ?>><?php echo e($status, false); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                    </div>         
                  </div>
                </div>

        <div class="col text-right">
            <div class="form-group row">
                <label class=" col col-form-label" for="class_id">Term</label>
                <div class="col">
                      <select  class="custom-select" name="filter_term" id="filter_term" onchange="document.forms['frmcampus'].submit()">
                          <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($term, false); ?>" <?php echo e(old('filter_term') == $term ? 'selected' : '', false); ?> <?php echo e($term==$current_filter['term']?'selected':'', false); ?>><?php echo e($term, false); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                </div>         
              </div>
            </div>

        <div class="col text-right">
            <div class="form-group row">
                <label class=" col col-form-label" for="class_id">Class</label>
                <div class="col">
                      <select  class="custom-select" name="filter_class" id="filter_class" onchange="document.forms['frmcampus'].submit()">
                          <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($id, false); ?>" <?php echo e(old('filter_class') == $id ? 'selected' : '', false); ?> <?php echo e($id==$current_filter['class']?'selected':'', false); ?>><?php echo e($class, false); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                </div>         
              </div>
            </div>
         <div class="col  text-right">
            <div class="form-group row text-nowrap">
            <label class="col col-form-label" for="class_id">Language</label>
            <div class="col-6">
                  <select  class="custom-select" name="filter_language" id="filter_language" onchange="document.forms['frmcampus'].submit()">
                      <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($language, false); ?>" <?php echo e(old('filter_language') == $language ? 'selected' : '', false); ?> <?php echo e($language==$current_filter['language']?'selected':'', false); ?>><?php echo e($language, false); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
            </div>  
            </div> 
         </div>  
         
         <div class="col text-right">
            <div class="form-group row">
            <label class=" col col-form-label" for="filter_course">Course</label>
            <div class="col-8">
                  <select  class="custom-select" name="filter_course" id="filter_course" onchange="document.forms['frmcampus'].submit()">
                      <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($id, false); ?>" <?php echo e(old('filter_course') == $id ? 'selected' : '', false); ?> <?php echo e($id==$current_filter['course']?'selected':'', false); ?>><?php echo e($course, false); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
            </div>  
            </div> 
         </div>  

        </div>

  
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display table-striped" id="tbl_homework" style="width:100%">
                <thead>
                    <tr>
                        <th width="10">
                            No
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Created Date
                        </th>    
                        <th>
                            Due Date
                        </th>    
                        <th>
                            Assigned Course
                        </th>                
                        <th>
                            Title
                        </th>
                        <th>
                            Marks
                        </th>
                        <th>
                            Class
                        </th>
                        
                        <th>
                            Student Submit
                        </th>
                        
                        <th>
                            #
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
<script src="<?php echo e(asset('js/xzoom.min.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/magnific-popup.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/jquery.hammer.min.js'), false); ?>"></script>
<script>
    $(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

   // $.fn.dataTable.ext.errMode = 'none';

        var classes ='', language='', course ='';

        var table1 = $('#tbl_homework').on("draw.dt", function () {
            $(this).find(".dataTables_empty").parents('tbody').empty();
        }).DataTable({
        destroy: true,
        processing: false,
        serverSide: true,
        paging: true,
        bFilter: true,
        bInfo:true,
        order: [[1, 'desc']],
        // columnDefs: [{ visible: false, targets: 1 }],
       // "ordering": false,
        // oLanguage:{
        //     "sSearch":'Search only[Student ID, English Name]: '
        // },
       // "deferLoading": 0,
        ajax: {
            'dataType':'json',
            url:"<?php echo e(route('admin.homework.ajaxhomework'), false); ?>?completed=0",
            'data': {'filter': <?php echo json_encode($current_filter); ?> }
        },
        cache:false,
        // buttons: [],
        select: false,
        columnDefs:[
            {
            'targets':[1],
            'visible':false,
            
            },
            {
             'targets':[0,2,3,4,5,6,7,8,9],
             'orderable': false 
            }
        ],
       
        columns: [
            {data: 'DT_RowIndex', 
            // name : 'DT_RowIndex',
            // "render": function(data,type){
                
            //     return '<h5 class="text-center p-2 m-0">' + (data + (next_page -1) * lengthrow) + '</h5>';
            // },
            class:'text-center align-middle ext-weight'
           
            },
            {data: 'group_col',name:'group_col',class:' align-middle text-weight-normal'},
            {data: 'added_on_date',name:'added_on_date',class:' align-middle text-weight-normal'},
            {data: 'due_date', name : 'due_date' ,  class:' align-middle text-weight-normal'},
            {data: 'course_name', name : 'course_name',class:'text-weight-normal align-middle'},
            {data: 'name', name : 'name',class:'align-left align-middle text-weight-normal'},
            {data: 'marks', name : 'marks', class:'align-middle text-weight-normal'},
            {data: 'class_name', name : 'class_name', class:'text-weight-normal align-middle'},
            
        //    {data: 'submitted', name : 'submitted',class:'text-weight-normal align-middle text-center'},
            {data: 'student_submit', name : 'student_submit',class:'text-center align-middle'},
            {data: 'action', name : 'action',class:'text-left text-nowrap align-middle'},
            
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
 
            api
                .column(1, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before('<tr class="group bg-primary text-white"><td colspan="10"><strong>' + group + '</strong></td></tr>');
 
                        last = group;
                    }
                });
        },
    });

    $('.xzoom-gallery').bind('click', function(event) {
            var div= $(this).parents('.xzoom-thumbs');
            // var xzoom = $(this).data('xzoom');
            // xzoom.closezoom();
            // var gallery = xzoom.gallery().cgallery;
            // var i, images = new Array();
            // for (i in gallery) {
            //     images[i] = {src: gallery[i]};
            // }
            images = new Array();

            var img_length = div.find('img').length;
            for(i=0;i<img_length;i++)
            images[i]= {src: div.find('img').eq(i).attr("src")};
            $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
            event.preventDefault();
});


  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.datatables.delete'), false); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.course.massDestroy'), false); ?>",
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
    //order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/homework/index.blade.php ENDPATH**/ ?>