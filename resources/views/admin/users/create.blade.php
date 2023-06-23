@extends('layouts.admin')

@section('styles')
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
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }}
            {{ request()->has('teacher') ? 'Teacher' : (request()->has('student') ? 'Student' : trans('cruds.user.title_singular')) }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }} (English)</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                for="email">{{ !request()->has('student') ? 'Email' : 'Student ID' }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                                name="email" id="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        @if (request()->has('student') || request()->has('teacher'))
                            <div class="form-group">
                                <label class="required" for="phone">{{ 'Phone' }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                                    name="phone" id="phone" value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="" for="namekh">{{ trans('cruds.user.fields.name') }} (Khmer)</label>
                            <input class="form-control {{ $errors->has('namekh') ? 'is-invalid' : '' }}" type="text"
                                name="namekh" id="namekh" value="{{ old('namekh') }}">
                            @if ($errors->has('namekh'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('namekh') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                                name="password" id="password">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>

                        @if (request()->has('student'))
                            <div class="row">

                                <div class="col-8">
                                    <div class="form-group">
                                        <label>
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" id="scanrfid_option">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked">{{ 'RFID Card' }}</label>
                                            </div>
                                        </label>

                                        <input class="form-control {{ $errors->has('rfidcard') ? 'is-invalid' : '' }}"
                                            readonly type="text" name="rfidcard" id="rfidcard"
                                            value="{{ old('rfidcard') }}">
                                        @if ($errors->has('rfidcard'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('rfidcard') }}
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-nowrap align-bottom">
                                        {{-- <label class="" for="rfidcard">{{ 'Upload Voice (Audio)' }}</label> --}}
                                        <br />
                                        <input name="audio_voice" id="audio_voice" class="file-upload-input" type='file'
                                            accept="audio/mp3" />
                                        {{-- onchange="readURL(this);" --}}
                                        <button class="btn btn-sm btn-primary" style="position:inline" type="button"
                                            onclick="$('.file-upload-input').trigger( 'click' )">Upload Voice
                                            (Audio)</button>
                                        <audio controls autoplay
                                            style="height: 10px; width: 150px;position:inline;padding-top:10px;margin:0"></audio>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <img src="{{ asset('storage/image/' . (request()->has('student') ? 'student-avatar.png' : 'teacher-avatar.png')) }}"
                                class="img-thumbnail btn btn-outline-primary" id="img_thumbnail" alt="select thumbnail"
                                width="150px" height="150px">
                            <input type="file" id="imgupload" name="imgupload" style="display:none" />
                        </div>
                        <div class="form-group">

                            {{-- {!! empty($user->rfidcard) ? '' : QrCode::size(150)->generate($user->rfidcard); !!} --}}
                        </div>
                    </div>
                </div>
                <div class="row">

                    @if (request()->has('teacher'))
                        <div class="col-6">
                            <div class="form-group">
                                <label class="" for="class_id">{{ trans('cruds.user.fields.class') }}</label>

                                <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                    name="class_id[]" id="class_id" multiple>
                                    @foreach ($classes as $id => $class)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('class_id', [])) ? 'selected' : '' }}>
                                            {{ $class }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('class') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.class_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="" for="course_id">Course</label>

                                <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                    name="course_id[]" id="course_id" multiple>
                                    @foreach ($courses as $id => $course)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('course_id', [])) ? 'selected' : '' }}>
                                            {{ $course }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('course'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('course') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.user.fields.class_helper') }}</span>
                            </div>

                        </div>
                    @endif
                </div>
                @if (request()->has('teacher'))
                    <input type="hidden" name="roles[]" value="3">
                @elseif(request()->has('student'))
                    <input type="hidden" name="roles[]" value="4">
                @else
                    <div class="form-group">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all"
                                style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all"
                                style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}"
                            name="roles[]" id="roles" multiple required>
                            @foreach ($roles as $id => $roles)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                    </div>
                @endif
                @if (request()->has('student'))
                    {{-- For Student path --}}

                    <div class="form-group">
                        <label class="required" for="class_id">{{ trans('cruds.user.fields.class') }}</label>
                        <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                            name="class_id" id="class_id" required>
                            @foreach ($classes as $id => $class)
                                <option value="{{ $id }}" {{ old('class_id') == $id ? 'selected' : '' }}>
                                    {{ $class }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('class'))
                            <div class="invalid-feedback">
                                {{ $errors->first('class') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.class_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="" for="guardian_info">Collection Card</label>
                    </div>
                    <div class="row">
                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="{{ asset('storage/image/guardian-avatar.png') }}"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail1"
                                    alt="select thumbnail" width="150px" height="150px">
                                <input type="file" id="collect_imgupload1" name="collect_imgupload1"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian1" id="guardian1" class="form-select">
                                    @foreach ($collection_guardian as $item)
                                        <option value="{{ $item == 'Select One Item' ? '' : $item }}"
                                            {{ old('guardian1') == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="{{ asset('storage/image/guardian-avatar.png') }}"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail2"
                                    alt="select thumbnail" width="150px" height="150px">
                                <input type="file" id="collect_imgupload2" name="collect_imgupload2"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian2" id="guardian2" class="form-select">
                                    @foreach ($collection_guardian as $item)
                                        <option value="{{ $item == 'Select One Item' ? '' : $item }}"
                                            {{ old('guardian2') == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-2 text-center">
                            <div class="form-group">
                                <img src="{{ asset('storage/image/guardian-avatar.png') }}"
                                    class="img-thumbnail btn btn-outline-primary" id="collect_thumbnail3"
                                    alt="select thumbnai" width="150px" height="150px">
                                <input type="file" id="collect_imgupload3" name="collect_imgupload3"
                                    style="display:none" />
                            </div>
                            <div class="form-group">
                                <select name="guardian3" id="guardian3" class="form-select">
                                    @foreach ($collection_guardian as $item)
                                        <option value="{{ $item == 'Select One Item' ? '' : $item }}"
                                            {{ old('guardian3') == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-6 text-right">
                    <div class="form-group">
                        
                           
                        
                    </div>
                </div> --}}
                    </div>
                @endif
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>


    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/jquery.rfid.js') }}"></script>
    @parent
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
@endsection
