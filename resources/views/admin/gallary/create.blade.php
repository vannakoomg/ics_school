@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }}
        </div>
    </div>
    <div class="container">
        <div>
            <form method="POST" action="http://127.0.0.1:8000/admin/gallary" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="required" for="title">title</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('name', '') }}" required>
                </div>
                <div>
                    <label>Choose Images</label>
                    <input type="file" name="images" multiple>
                </div>
                <hr>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
