<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale()), false); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

    <title><?php echo e(config('app.name', 'APILogger'), false); ?></title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></head>
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
<body style="font-family: 'Nunito', sans-serif;font-size: 0.9rem;line-height: 1.6">
    <div class="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo e(url('/'), false); ?>">
                    <?php echo e(config('app.name', 'APILogger'), false); ?>

                </a>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="w-100 d-flex justify-content-between">
                    <h3 class="text-center">Api Logger</h3>
                    <form method="POST" action="<?php echo e(route('apilogs.deletelogs'), false); ?>">
                        <?php echo e(csrf_field(), false); ?>

                        <?php echo e(method_field('DELETE'), false); ?>

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger delete-logs" value="Delete Logs">
                        </div>
                    </form>
                </div>
                <div class="list-group">
                    <?php $__empty_1 = true; $__currentLoopData = $apilogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="list-group-item list-group-item-action" style="margin:5px">
                        <div class = "row w-100">
                            <span class="col-md-3">
                                <?php if($log->response>400): ?>
                                    <button class="btn btn-danger font-weight-bold"><?php echo e($log->method, false); ?></button>
                                <?php elseif($log->response>300): ?>
                                    <button class="btn btn-info font-weight-bold"><?php echo e($log->method, false); ?></button>
                                <?php else: ?>
                                    <button class="btn btn-<?php echo e($log->method=="GET"? "primary" : "success", false); ?> font-weight-bold"><?php echo e($log->method, false); ?></button>
                                <?php endif; ?>
                                
                                <small class="col-md-2">
                                    <b><?php echo e($log->response, false); ?></b>
                                </small>
                            </span>
                            <large class= "col-md-3"><b>Duration : </b><?php echo e($log->duration * 1000, false); ?>ms</large>
                            <large class= "col-md-3"><b>Date : </b><?php echo e($log->created_at, false); ?></large>
                            <p class="col-md-3 mb-1"><b>IP :</b> <?php echo e($log->ip, false); ?></p>
                        </div>
                        <hr>
                        <div class="row w-100">
                            <p class="col-md-3 mb-1">
                                <b>URL : </b><?php echo e($log->url, false); ?></br>
                            </p>
                            <p class="col-md-6 mb-1"><b>Models(Retrieved) :</b> <?php echo e($log->models, false); ?></p>
                        </div>
                        <div class="row w-100">
                                <p class="col-md-3">
                                    <b>Method :</b>   <?php echo e($log->action, false); ?>

                                </p>
                                <p class="col-md-3 mb-1"><b>Payload : </b><?php echo e($log->payload, false); ?></p>

                                <p class="col-md-6">
                                    <b>Controller :</b> <?php echo e($log->controller, false); ?>

                                    
                                </p>
                            
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <h5>
                      No Records
                    </h5>
                  <?php endif; ?>
                
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<?php /**PATH /mnt/hdd/www/school/vendor/awt/apilogger/src/Providers/../../resources/views/index.blade.php ENDPATH**/ ?>