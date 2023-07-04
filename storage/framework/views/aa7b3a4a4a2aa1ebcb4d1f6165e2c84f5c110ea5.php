
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            Create
        </div>
        <div class="card-body">
            <form method="POST" action=<?php echo e(route('admin.gallary.store'), false); ?> enctype="multipart/form-data" class="dropzone"
                id="dropzone">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="requires" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="" />
                </div>
                <div class="form-group">
                    <label class="" for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description" />
                </div>
            </form>
            <button class="btn btn-success mt-3  pl-4 pr-4" type="submit" id="uploadfiles">
                <?php echo e(trans('global.save'), false); ?>

            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            headers: {
                'X-CSRFToken': $('meta[name="token"]').attr('content')
            },
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10000, // Number of files process at a time (default 2)
            maxFilesize: 10000, //maximum file size 2MB
            maxFiles: 100,
            addRemoveLinks: "true",
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            dictDefaultMessage: '<div class="dropzone_bx"><button type="button">Browse a file</button></div>',
            dictResponseError: 'Error uploading file!',
            thumbnailWidth: "150",
            thumbnailHeight: "150",
            createImageThumbnails: true,
            dictRemoveFile: "Remove",
        });
        Dropzone.autoDiscover = false;
        myDropzone.on("success", function(file, response) {
            console.log(response);
        });
        $('#uploadfiles').click(function() {
            myDropzone.processQueue();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/gallary/create.blade.php ENDPATH**/ ?>