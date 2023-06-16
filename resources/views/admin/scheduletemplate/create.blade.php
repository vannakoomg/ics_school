@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Schedule Template
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.scheduletemplate.store") }}" enctype="multipart/form-data">
            @csrf
         
<div class="row">
    <div class="col-6">
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.schoolClass.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>
    </div>
    <div class="col-6">
            <div class="form-group">
                <label class="required" for="type">Type</label>
                    <select name='type' class="custom-select select2">
                        @foreach($types as $id => $type)
                            <option value="{{ $type }}">{{ $type }}</option>
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
