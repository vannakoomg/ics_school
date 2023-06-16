<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

    <title><?php echo e(trans('panel.site_title'), false); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    
    <link href="<?php echo e(asset('css/datatables/datatables.bootstrap4.min.css'), false); ?>" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/datatables/select.datatables.min.css'), false); ?>" rel="stylesheet" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.buttons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.brighttheme.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/full-screen-helper.css'), false); ?>" rel="stylesheet" />
    

    <link href="<?php echo e(asset('css/custom.css'), false); ?>" rel="stylesheet" />
    
    <?php echo $__env->yieldContent('styles'); ?>
    <style>
        .panel-actions {
        /* margin-top: -30px; */
        margin-right: 10px;
        margin-bottom: 0px;
        text-align: right;
        } 
        .panel-actions a {
        color:#333;
        }

        .panel-fullscreen {
            display: block;
            z-index: 9999;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            overflow: auto;
        }

        .box {
        margin: 10px;
        padding: 10px;
        background-color: #ccc !important;
        border-radius: 4px;
        font-size: 120%;
    }

    .full-screen-helper {
        border-radius: 0 !important;
        overflow: auto !important;
    }

    </style>
</head>

<body class="app header-fixed sidebar-fixed <?php echo e(request()->is('admin/timetable/create') || request()->is('admin/calling_dashboard/*') || request()->is('admin/createexamschedule') ? 'sidebar-minimized':'', false); ?>  aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header">
      <nav class="navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full"><?php echo e(trans('panel.site_title'), false); ?></span>
            <span class="navbar-brand-minimized">ICS</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-text">
          Welcome , <strong><?php echo e((auth()->user()->name), false); ?></strong>
        </span>
        <ul class="nav navbar-nav ml-auto">
            <?php if(count(config('panel.available_languages', [])) > 1): ?>
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(strtoupper(app()->getLocale()), false); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php $__currentLoopData = config('panel.available_languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langLocale => $langName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item" href="<?php echo e(url()->current(), false); ?>?change_language=<?php echo e($langLocale, false); ?>"><?php echo e(strtoupper($langLocale), false); ?> (<?php echo e($langName, false); ?>)</a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </li>
            <?php endif; ?>


        </ul>
        
      </nav>
    </header>

    <div class="app-body">
        <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">
                <?php if(session('message')): ?>
                    
                    
                    <div class="alert alert-success alert-solid alert-dismissible shadow-sm p-3 rounded" 
                    role="alert">
                    <?php echo e(session('message'), false); ?>

                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                  </button>
               </div>

                <?php endif; ?>
                <?php if($errors->count() > 0): ?>
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error, false); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>

            </div>

        </main>
        <form id="logoutform" action="<?php echo e(route('logout'), false); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field(), false); ?>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    
    
    
   
    

    

    <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
    <script src="<?php echo e(asset('js/datatables/jquery.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/datatables.select.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/dataTables.bootstrap4.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/dataTables.buttons.min.js'), false); ?>"></script>
   
    <script src="<?php echo e(asset('js/datatables/buttons.html5.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/buttons.print.min.js'), false); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/buttons.colVis.min.js'), false); ?>"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="<?php echo e(asset('js/full-screen-helper.min.js'), false); ?>"></script>
    

   <script src="<?php echo e(asset('js/main.js'), false); ?>" type="text/javascript"></script>

   <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
  <script src="https://js.pusher.com/beams/2.0.0-beta.1/push-notifications-cdn.js"></script>
  
<script>

  function go_logout(e){
        //console.log('test click');
       // beamsClient.stop();
       // beamsClient.removeDeviceInterest('<?php echo e(config('services.pusher')['interest'], false); ?>');// for pusher bean
             document.getElementById('logoutform').submit();

   }

   $(function() {
  let copyButtonTrans = '<?php echo e(trans('global.datatables.copy'), false); ?>'
  let csvButtonTrans = '<?php echo e(trans('global.datatables.csv'), false); ?>'
  let excelButtonTrans = '<?php echo e(trans('global.datatables.excel'), false); ?>'
  let pdfButtonTrans = '<?php echo e(trans('global.datatables.pdf'), false); ?>'
  let printButtonTrans = '<?php echo e(trans('global.datatables.print'), false); ?>'
  let colvisButtonTrans = '<?php echo e(trans('global.datatables.colvis'), false); ?>'
  let selectAllButtonTrans = '<?php echo e(trans('global.select_all'), false); ?>'
  let selectNoneButtonTrans = '<?php echo e(trans('global.deselect_all'), false); ?>'

//   let languages = {
//     'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
//   };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  
  $.fn.dataTable.defaults.button_noselect = [
     
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ];

  $.extend(true, $.fn.dataTable.defaults, {
//     language: {
//       url: languages['<?php echo e(app()->getLocale(), false); ?>']
//     },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 30,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'selectAll',
        className: 'btn-primary',
        text: selectAllButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'selectNone',
        className: 'btn-primary',
        text: selectNoneButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';

  // if (typeof FullScreenHelper === "undefined") {
  //       document.write("<p>FullScreenHelper is not loaded</p>");
  //   } else if (FullScreenHelper.supported()) {
  //       document.write("<p>Fullscreen is supported</p>");
  //   } else {
  //       document.write("<p>Your browser don't support fullscreen</p>");
  //   }

    FullScreenHelper.on(function () {
        if (FullScreenHelper.state()) {
            console.log("In fullscreen", FullScreenHelper.current());
        } else {
            console.log("Not in fullscreen");
        }
    });

  $("#panel-fullscreen").click(function (e) {
        e.preventDefault();
        //FullScreenHelper.request(document);
        FullScreenHelper.toggle(document.getElementsByClassName('card')[0]);
        
      //  // console.log('dd');
      //   var $this = $(this);
    
      //       if ($this.children('i').hasClass('fa-up-right-and-down-left-from-center'))
      //       {
      //           $this.children('i').removeClass('fa-up-right-and-down-left-from-center');
      //           $this.children('i').addClass('fa-down-left-and-up-right-to-center');
      //       }
      //       else if ($this.children('i').hasClass('fa-down-left-and-up-right-to-center'))
      //       {
      //           $this.children('i').removeClass('fa-down-left-and-up-right-to-center');
      //           $this.children('i').addClass('fa-up-right-and-down-left-from-center');
      //       }
            
      //       $(this).parent('.card').toggleClass('panel-fullscreen');
        });

});

    //onclick="event.preventDefault(); if(beamsClient) beamsClient.stop(); document.getElementById('logoutform').submit();"

    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/layouts/admin.blade.php ENDPATH**/ ?>