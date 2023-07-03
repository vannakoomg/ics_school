@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit
        </div>
        <div class="card-body">
            <form method="POST" action="http://127.0.0.1:8000/admin/gallary" enctype="multipart/form-data" class="dropzone"
                id="dropzone">
                @csrf
                <div class="form-group">
                    <label class="requires" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $gallary->name }}" />
                </div>
                <div class="form-group">
                    <label class="" for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description"
                        value="{{ $gallary->description }}" />
                </div>
            </form>
            <button class="btn btn-success mt-4" type="submit" id="update-btn">
                {{ trans('global.save') }}
            </button>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100, // Number of files process at a time (default 2)
            maxFilesize: 100, //maximum file size 2MB
            maxFiles: 50,
            addRemoveLinks: "true",
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            dictDefaultMessage: '<div class="dropzone_bx"><button type="button">Browse a file</button></div>',
            dictResponseError: 'Error uploading file!',
            thumbnailWidth: "150",
            thumbnailHeight: "150",
            createImageThumbnails: true,
            dictRemoveFile: "Remove",
            init: function() { // start of getting existing imahes
                myDropzone = this;
                $.ajax({
                    url: "http://127.0.0.1:8000/admin/gallary/init",
                    type: "GET",
                    data: {
                        id: 1,
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    dataType: "json",
                    success: function(response) { // get result
                        console.log(response);
                        $.each(response, function(key, value) {
                            var mockFile = {
                                name: value.filename,
                                size: value.size
                            };
                            myDropzone.options.addedfile.call(
                                myDropzone,
                                mockFile
                            );
                            myDropzone.options.thumbnail.call(
                                myDropzone,
                                mockFile,
                                "storage/products/" + value.name
                            );
                            $("[data-dz-thumbnail]").css("height", "120");
                            $("[data-dz-thumbnail]").css("width", "120");
                            $("[data-dz-thumbnail]").css("object-fit", "cover");
                        });

                        // myDropzone.on("sending", function(file, xhr, formData) {
                        //     // Append all form inputs to the formData Dropzone will POST
                        //     var data = $("#editForm").serializeArray();
                        //     $.each(data, function(key, el) {
                        //         formData.append(el.name, el.value);
                        //     });
                        // });
                    }
                });
            },
        });
        myDropzone.on("success", function(file, response) {
            console.log(response);
        });
        $('#update-btn').click(function() {
            e.preventDefault();
            myDropzone.processQueue();
        });
    </script>
@endsection
