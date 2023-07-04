@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.events.index') }}" enctype="multipart/form-data">
                @csrf
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
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="time" id="name" value="{{ old('name', '') }}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="" for="template_id">Action</label>
                            <select name='action' class="custom-select select2">
                                @foreach ($eventsType as $Type)
                                    <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="required" for="From Date">title</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('name', '') }}" required>
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
        $(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD'
            });;
        });
    </script>
@endsection
