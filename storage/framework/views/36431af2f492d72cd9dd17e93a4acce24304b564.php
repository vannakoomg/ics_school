
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status'), false); ?>

                            </div>
                        <?php endif; ?>

                        
                        <?php if(auth()->user()->is_teacher): ?>
                            <div class="row">
                                <div class="col-lg">
                                    <div class="card">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>School Class Information</strong>
                                            </li>
                                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item"><?php echo e($class->name, false); ?> <span
                                                        class="badge badge-primary"><?php echo e($class->campus, false); ?></span> => Total
                                                    Students <span
                                                        class="badge badge-success"><?php echo e($class->classUsers->count(), false); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="card">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>Assignment Information</strong></li>
                                            
                                            </li>
                                        </ul>
                                        <div class="accordion" id="accordionExample">

                                            <div class="card mb-0">
                                                <div class="card-header" id="headingOne">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button"
                                                            data-toggle="collapse" data-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Unpublish Assignment <span
                                                                class="badge badge-warning"><?php echo e(count($data['unpublish']), false); ?></span>
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            <?php $__currentLoopData = $data['unpublish']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="list-group-item"><?php echo e($n + 1, false); ?>-
                                                                    <?php echo e($d->course->name, false); ?>: <?php echo e($d->name, false); ?></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left collapsed"
                                                            type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Published Assignment <span
                                                                class="badge badge-primary"><?php echo e(count($data['publish']), false); ?></span>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            <?php $__currentLoopData = $data['publish']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="list-group-item"><?php echo e($n + 1, false); ?>-
                                                                    <?php echo e($d->course->name, false); ?>: <?php echo e($d->name, false); ?></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col">

                                    <div class="card">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>Student Submitted Assignment</strong>
                                            </li>
                                            <li class="list-group-item">

                                                <table class="table table-sm display">
                                                    <thead>
                                                        <tr>
                                                            <td>No</td>
                                                            <td>Student Name</td>
                                                            <td>Assignment</td>
                                                            <td>Class</td>
                                                            <td>Campus</td>
                                                            <td>Submitted Date</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $assign_returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($no + 1, false); ?></td>
                                                                <td><?php echo e($assignment->student->name, false); ?></td>
                                                                <td><?php echo e($assignment->homework->name, false); ?></td>
                                                                <td><?php echo e($assignment->student->class->name, false); ?></td>
                                                                <td><?php echo e($assignment->student->class->campus, false); ?></td>
                                                                <td><?php echo e($assignment->turnedindate->format('d-m-Y h:i A'), false); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/home.blade.php ENDPATH**/ ?>