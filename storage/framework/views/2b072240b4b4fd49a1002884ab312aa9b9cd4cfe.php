

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create'), false); ?>

        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.events.index'), false); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="from_date"> Start Date </label>
                            <input id="startdate" name="startdate" type="text" class="form-control datetimepicker"
                                value="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="to_date">End Date </label>
                            <input id="id" name="end_date" type="text" class="form-control datetimepicker"
                                value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="required" for="time">Time</label>
                            <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text"
                                name="time" id="name" value="<?php echo e(old('name', ''), false); ?>" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="template_id">Action</label>
                            <select name='action' class="custom-select select2">
                                <?php $__currentLoopData = $eventsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($Type->id, false); ?>"><?php echo e($Type->name, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="required" for="From Date">title</label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text" name="title"
                        id="title" value="<?php echo e(old('name', ''), false); ?>" required>
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
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD'
            });;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/events/create.blade.php ENDPATH**/ ?>