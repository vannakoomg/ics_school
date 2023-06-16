<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(trans('panel.site_title')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    
    <link href="<?php echo e(asset('css/datatables/datatables.bootstrap4.min.css')); ?>" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/datatables/select.datatables.min.css')); ?>" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.buttons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.brighttheme.min.css" rel="stylesheet" />

    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="app header-fixed sidebar-fixed <?php echo e(request()->is('admin/dlp') ? 'sidebar-minimized':''); ?>  aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full"><?php echo e(trans('panel.site_title')); ?></span>
            <span class="navbar-brand-minimized"><?php echo e(trans('panel.site_title')); ?></span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="nav navbar-nav ml-auto">
            <?php if(count(config('panel.available_languages', [])) > 1): ?>
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(strtoupper(app()->getLocale())); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php $__currentLoopData = config('panel.available_languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langLocale => $langName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item" href="<?php echo e(url()->current()); ?>?change_language=<?php echo e($langLocale); ?>"><?php echo e(strtoupper($langLocale)); ?> (<?php echo e($langName); ?>)</a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </li>
            <?php endif; ?>


        </ul>
    </header>

    <div class="app-body">
        <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">
                <?php if(session('message')): ?>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert"><?php echo e(session('message')); ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($errors->count() > 0): ?>
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>

            </div>

        </main>
        <form id="logoutform" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
    <script src="<?php echo e(asset('js/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/dataTables.buttons.min.js')); ?>"></script>
   
    <script src="<?php echo e(asset('js/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatables/buttons.colVis.min.js')); ?>"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="<?php echo e(asset('js/datatables/datatables.select.min.js')); ?>"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.buttons.min.js"></script>

   <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>

<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script src="https://js.pusher.com/beams/2.0.0-beta.1/push-notifications-cdn.js"></script>
<script>


  const beamsClient = new PusherPushNotifications.Client({
    instanceId: '8aefb6b4-0974-4390-90cd-0adeb1514910',
        secretKey: 'E1581BA1EAEBCED979ACD8902BC98170DE3536E1584360DA0FD883433A254BEF',
  });



setDevice();

function setDevice() {
//beamsClient.stop();

// beamsClienti
//   .start()
//   .then((beamsClient) => beamsClient.getDeviceId())
//   .then((deviceId) =>
//     console.log("Successfully registered with Beams. Device ID:", deviceId)
//   )
//   .then(() => beamsClient.addDeviceInterest("<?php echo e(config('services.pusher')['interest']); ?>"))
//   .then(() => beamsClient.getDeviceInterests())
//   .then((interests) => console.log("Current interests:", interests))
//   .catch(console.error);

const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
  url: "<?php echo e(route('pusher.auth')); ?>",
//   queryParams: {
//     someQueryParam: "parameter-content", // URL query params your auth endpoint needs
//    },
//   headers: {
//     someHeader: "header-content", // Headers your auth endpoint needs
//   },
//   credentials: {
//      user_id: '<?php echo e(auth()->user()->id); ?>',
//   }

});

// console.log(beamsTokenProvider);

beamsClient
  .getUserId()
  .then((userId) => {
    // Check if the Beams user matches the user that is currently logged in
    if (userId !== '<?php echo e(auth()->user()->name); ?>') {
      // Unregister for notifications
      return beamsClient.stop();
    }
  })
  .catch(console.error);

// beamsClient
//  .getUserId()
//  .then((userId) => {
//    console.log(userId);
//  });

 beamsClient
 .start()
 .then(() => beamsClient.setUserId('<?php echo e(auth()->user()->name); ?>', beamsTokenProvider))
 .then(() => document.getElementById('btn_notification').style.display = "none")
  .catch(console.error);
   //end of window.load event




}



  function go_logout(e){
        //console.log('test click');
       // beamsClient.stop();
       // beamsClient.removeDeviceInterest('<?php echo e(config('services.pusher')['interest']); ?>');// for pusher bean
       beamsClient.stop()
       .then(() => {
             document.getElementById('logoutform').submit();
       })
       .catch(console.error);


   }

   $(function() {
  let copyButtonTrans = '<?php echo e(trans('global.datatables.copy')); ?>'
  let csvButtonTrans = '<?php echo e(trans('global.datatables.csv')); ?>'
  let excelButtonTrans = '<?php echo e(trans('global.datatables.excel')); ?>'
  let pdfButtonTrans = '<?php echo e(trans('global.datatables.pdf')); ?>'
  let printButtonTrans = '<?php echo e(trans('global.datatables.print')); ?>'
  let colvisButtonTrans = '<?php echo e(trans('global.datatables.colvis')); ?>'
  let selectAllButtonTrans = '<?php echo e(trans('global.select_all')); ?>'
  let selectNoneButtonTrans = '<?php echo e(trans('global.deselect_all')); ?>'

//   let languages = {
//     'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
//   };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
//     language: {
//       url: languages['<?php echo e(app()->getLocale()); ?>']
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
    pageLength: 100,
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


});

    //onclick="event.preventDefault(); if(beamsClient) beamsClient.stop(); document.getElementById('logoutform').submit();"

    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH /var/www/icsapp/resources/views/layouts/admin.blade.php ENDPATH**/ ?>