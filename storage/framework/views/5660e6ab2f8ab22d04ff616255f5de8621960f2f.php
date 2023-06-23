

<?php $__env->startSection('styles'); ?>
    <meta name="og:url" property="og:url"
        content='https://www.aspsnippets.com/questions/198784/Play-audio-mp3-with-HTML5-audio-player-using-jQuery-in-ASPNet/demos/1' />

    <style>
        .file-upload {
            background-color: #ffffff;
            width: 250px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #1FB264;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #15824B;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #1AA059;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #1FB264;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #1FB264;
            border: 4px dashed #ffffff;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #15824B;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 200px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create'), false); ?>

            <?php echo e(request()->has('teacher') ? 'Teacher' : (request()->has('student') ? 'Student' : trans('cruds.user.title_singular')), false); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.users.store'), false); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="required" for="name"><?php echo e(trans('cruds.user.fields.name'), false); ?> (English)</label>
                            <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" type="text"
                                name="name" id="name" value="<?php echo e(old('name'), false); ?>" required>
                            <?php if($errors->has('name')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('name'), false); ?>

                                </div>
                            <?php endif; ?>
                            <span class="help-block"><?php echo e(trans('cruds.user.fields.name_helper'), false); ?></span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                for="email"><?php echo e(!request()->has('student') ? 'Email' : 'Student ID', false); ?></label>
                            <input class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : '', false); ?>" type="text"
                                name="email" id="email" value="<?php echo e(old('email'), false); ?>" required>
                            <?php if($errors->has('email')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('email'), false); ?>

                                </div>
                            <?php endif; ?>
                            <span class="help-block"><?php echo e(trans('cruds.user.fields.email_helper'), false); ?></span>
                        </div>
                        <?php if(request()->has('student') || request()->has('teacher')): ?>
                            <div class="form-group">
                                <label class="required" for="phone"><?php echo e('Phone', false); ?></label>
                                <input class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : '', false); ?>" type="text"
                                    name="phone" id="phone" value="<?php echo e(old('phone'), false); ?>" required>
                                <?php if($errors->has('phone')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('phone'), false); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="" for="namekh"><?php echo e(trans('cruds.user.fields.name'), false); ?> (Khmer)</label>
                            <input class="form-control <?php echo e($errors->has('namekh') ? 'is-invalid' : '', false); ?>" type="text"
                                name="namekh" id="namekh" value="<?php echo e(old('namekh'), false); ?>">
                            <?php if($errors->has('namekh')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('namekh'), false); ?>

                                </div>
                            <?php endif; ?>
                            <span class="help-block"><?php echo e(trans('cruds.user.fields.name_helper'), false); ?></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password"><?php echo e(trans('cruds.user.fields.password'), false); ?></label>
                            <input class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : '', false); ?>" type="password"
                                name="password" id="password">
                            <?php if($errors->has('password')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('password'), false); ?>

                                </div>
                            <?php endif; ?>
                            <span class="help-block"><?php echo e(trans('cruds.user.fields.password_helper'), false); ?></span>
                        </div>

                        <?php if(request()->has('student')): ?>
                            <div class="row">

                                <div class="col-8">
                                    <div class="form-group">
                                        <label>
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" id="scanrfid_option">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked"><?php echo e('RFID Card', false); ?></label>
                                            </div>
                                        </label>

                                        <input class="form-control <?php echo e($errors->has('rfidcard') ? 'is-invalid' : '', false); ?>"
                                            readonly type="text" name="rfidcard" id="rfidcard"
                                            value="<?php echo e(old('rfidcard'), false); ?>">
                                        <?php if($errors->has('rfidcard')): ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($errors->first('rfidcard'), false); ?>

                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-nowrap align-bottom">
                                        
                                        <br />
                                        <input name="audio_voice" id="audio_voice" class="file-upload-input" type='file'
                                            accept="audio/mp3" />
                                        
                                        <button class="btn btn-sm btn-primary" style="position:inline" type="button"
                                            onclick="$('.file-upload-input').trigger( 'click' )">Upload Voice
                                            (Audio)</button>
                                        <audio controls autoplay
                                            style="height: 10px; width: 150px;position:inline;padding-top:10px;margin:0"></audio>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <img src="<?php echo e(asset('storage/image/' . (request()->has('student') ? 'student-avatar.png' : 'teacher-avatar.png')), false); ?>"
                                class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail"
                                width="150px" height="150px">
                            <input type="file" id="imgupload" name="imgupload" style="display:none" />
                        </div>
                        <div class="form-group">

                            
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php if(request()->has('teacher')): ?>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="" for="class_id"><?php echo e(trans('cruds.user.fields.class'), false); ?></label>

                                <select class="form-control select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>"
                                    name="class_id[]" id="class_id" multiple>
                                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id, false); ?>"
                                            <?php echo e(in_array($id, old('class_id', [])) ? 'selected' : '', false); ?>>
                                            <?php echo e($class, false); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('class')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('class'), false); ?>

                                    </div>
                                <?php endif; ?>
                                <span class="help-block"><?php echo e(trans('cruds.user.fields.class_helper'), false); ?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="" for="course_id">Course</label>

                                <select class="form-control select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>"
                                    name="course_id[]" id="course_id" multiple>
                                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id, false); ?>"
                                            <?php echo e(in_array($id, old('course_id', [])) ? 'selected' : '', false); ?>>
                                            <?php echo e($course, false); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('course')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('course'), false); ?>

                                    </div>
                                <?php endif; ?>
                                <span class="help-block"><?php echo e(trans('cruds.user.fields.class_helper'), false); ?></span>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
                <?php if(request()->has('teacher')): ?>
                    <input type="hidden" name="roles[]" value="3">
                <?php elseif(request()->has('student')): ?>
                    <input type="hidden" name="roles[]" value="4">
                <?php else: ?>
                    <div class="form-group">
                        <label class="required" for="roles"><?php echo e(trans('cruds.user.fields.roles'), false); ?></label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all"
                                style="border-radius: 0"><?php echo e(trans('global.select_all'), false); ?></span>
                            <span class="btn btn-info btn-xs deselect-all"
                                style="border-radius: 0"><?php echo e(trans('global.deselect_all'), false); ?></span>
                        </div>
                        <select class="form-control select2 <?php echo e($errors->has('roles') ? 'is-invalid' : '', false); ?>"
                            name="roles[]" id="roles" multiple required>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id, false); ?>"
                                    <?php echo e(in_array($id, old('roles', [])) ? 'selected' : '', false); ?>><?php echo e($roles, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('roles')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('roles'), false); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.roles_helper'), false); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(request()->has('student')): ?>
                    

                    <div class="form-group">
                        <label class="required" for="class_id"><?php echo e(trans('cruds.user.fields.class'), false); ?></label>
                        <select class="form-control select2 <?php echo e($errors->has('class') ? 'is-invalid' : '', false); ?>"
                            name="class_id" id="class_id" required>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id, false); ?>" <?php echo e(old('class_id') == $id ? 'selected' : '', false); ?>>
                                    <?php echo e($class, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('class')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('class'), false); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.class_helper'), false); ?></span>
                    </div>
                    <div class="form-group">
                        <label class="" for="guardian_info">Collection Card</label>
                    </div>
                    <div class="row">
                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="<?php echo e(asset('storage/image/guardian-avatar.png'), false); ?>"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail1"
                                    alt="select thumbnail" width="150px" height="150px">
                                <input type="file" id="collect_imgupload1" name="collect_imgupload1"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian1" id="guardian1" class="form-select">
                                    <?php $__currentLoopData = $collection_guardian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item == 'Select One Item' ? '' : $item, false); ?>"
                                            <?php echo e(old('guardian1') == $item ? 'selected' : '', false); ?>><?php echo e($item, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="<?php echo e(asset('storage/image/guardian-avatar.png'), false); ?>"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail2"
                                    alt="select thumbnail" width="150px" height="150px">
                                <input type="file" id="collect_imgupload2" name="collect_imgupload2"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian2" id="guardian2" class="form-select">
                                    <?php $__currentLoopData = $collection_guardian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item == 'Select One Item' ? '' : $item, false); ?>"
                                            <?php echo e(old('guardian2') == $item ? 'selected' : '', false); ?>><?php echo e($item, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="<?php echo e(asset('storage/image/guardian-avatar.png'), false); ?>"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail3"
                                    alt="select thumbnai" width="150px" height="150px">
                                <input type="file" id="collect_imgupload3" name="collect_imgupload3"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian3" id="guardian3" class="form-select">
                                    <?php $__currentLoopData = $collection_guardian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item == 'Select One Item' ? '' : $item, false); ?>"
                                            <?php echo e(old('guardian3') == $item ? 'selected' : '', false); ?>><?php echo e($item, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                <?php endif; ?>
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
    <script type="text/javascript" src="<?php echo e(asset('js/jquery.rfid.js'), false); ?>"></script>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script>
        $(function() {
            'use strict';

            var rfidParser = function(rawData) {
                console.log(rawData);
                if (rawData.length != 11) return null;
                else return rawData;

            };

            // Called on a good scan (company card recognized)
            var goodScan = function(cardData) {
                $("#rfidcard").val(cardData.substr(0, 10));

            };

            // Called on a bad scan (company card not recognized)
            var badScan = function() {
                console.log("Bad Scan.");
            };


            // Initialize the plugin.

            // var scanmachine = function(){
            //     return $.rfidscan({
            //         enabled: true,
            //         parser: rfidParser,
            //         success: goodScan,
            //         error: badScan
            // 	});
            // };

            // var pp=scanmachine(); 

            var default_scan = false;

            $('#scanrfid_option').change(function() {
                default_scan = !default_scan;
                if (default_scan)
                    $.rfidscan({
                        enabled: true,
                        parser: rfidParser,
                        success: goodScan,
                        error: badScan
                    });
                else {
                    $.rfidscan({
                        enabled: false,
                        parser: rfidParser,
                        success: goodScan,
                        error: badScan
                    });
                    $(document).unbind(".rfidscan");
                }

            });

            $('#img_thumbnail').click(function() {
                $('#imgupload').trigger('click');
            });

            $('#collect_thumbnail1').click(function() {
                $('#collect_imgupload1').trigger('click');
            });

            $('#collect_thumbnail2').click(function() {
                $('#collect_imgupload2').trigger('click');
            });

            $('#collect_thumbnail3').click(function() {
                $('#collect_imgupload3').trigger('click');
            });

            $('#imgupload').change(function(e) {
                var filename = e.target.files[0].name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    $('#img_thumbnail').attr('src', e.target.result);
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

            });


            $('#collect_imgupload1').change(function(e) {
                var filename = e.target.files[0].name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    $('#collect_thumbnail1').attr('src', e.target.result);
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

            });


            $('#collect_imgupload2').change(function(e) {
                var filename = e.target.files[0].name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    $('#collect_thumbnail2').attr('src', e.target.result);
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

            });


            $('#collect_imgupload3').change(function(e) {
                var filename = e.target.files[0].name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    $('#collect_thumbnail3').attr('src', e.target.result);
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

            });

            $("audio").hide();

            $('input[name="audio_voice"]').change(function() {
                var fileInput = document.getElementById('audio_voice');
                var files = fileInput.files;
                // console.log(files);
                var fileURL = URL.createObjectURL(files[0]);
                document.querySelector('audio').src = fileURL;
                $("audio").show();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wrok_in_ics\web_backend\resources\views/admin/users/create.blade.php ENDPATH**/ ?>