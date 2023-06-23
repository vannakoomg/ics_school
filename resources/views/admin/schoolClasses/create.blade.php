@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.schoolClass.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.school-classes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">

                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.schoolClass.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', '') }}" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('Campus') }}</label>
                            <select name='campus' class="custom-select" required>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus }}">{{ $campus }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('campus'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('campus') }}
                                </div>
                            @endif

                            <span class="help-block">{{ '' }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="roomno">{{ trans('Room No') }}</label>
                            <input type="text" class="form-control" name="roomno" id="roomno"
                                value="{{ old('roomno', '') }}" />
                            <span class="help-block">{{ '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">

                        <div class="form-group">
                            <label class="" for="homeroom_id">{{ trans('Homeroom') }}</label>
                            <select name='homeroom_id' class="custom-select">
                                @foreach ($teachers as $id => $teacher)
                                    <option value="{{ $id }}">{{ $teacher }}</option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="khteacher_id">{{ trans('Khmer Teacher') }}</label>
                            <select name='khteacher_id' class="custom-select">
                                @foreach ($teachers as $id => $teacher)
                                    <option value="{{ $id }}">{{ $teacher }}</option>
                                @endforeach
                            </select>

                            <span class="help-block">{{ '' }}</span>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="teacheraide_id">{{ trans('Teacher Aide') }}</label>
                            <select name='teacheraide_id' class="custom-select">
                                @foreach ($teachers as $id => $teacher)
                                    <option value="{{ $id }}">{{ $teacher }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="" for="template_id">{{ trans('Schedule Template') }}</label>
                            <select name='template_id[]' class="custom-select select2" multiple
                                data-maximum-selection-length="2">
                                @foreach ($templates as $id => $template)
                                    <option value="{{ $id }}">{{ $template }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="" for="template_id">{{ trans('Group') }}</label>
                            <select name='level_type' class="custom-select select2">
                                @foreach ($groups as $id => $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
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
    @parent
    <script>
        $(document).ready(function() {



            $('select[name="campus"]').on("change", function(e) {



                var id = $(this).val();

                // Empty the dropdown
                $('select[name="homeroom_id"]').find('option').not(':first').remove();
                $('select[name="khteacher_id"]').find('option').not(':first').remove();
                $('select[name="teacheraide_id"]').find('option').not(':first').remove();

                // AJAX request 
                $.ajax({
                    url: "{{ route('admin.getteacher', ['campus']) }}".replace('campus', id),
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $('select[name="homeroom_id"]').append(option);
                                $('select[name="khteacher_id"]').append(option);
                                $('select[name="teacheraide_id"]').append(option);

                            }
                        }

                    }
                });


            });

            $('select[name="campus"]').trigger('change');
        });
    </script>
@endsection
