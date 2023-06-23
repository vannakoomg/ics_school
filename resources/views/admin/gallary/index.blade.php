@extends('layouts.admin')

@section('content')
    @can('school_class_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="gallary/create">
                    {{ trans('global.add') }} {{ trans('cruds.schoolClass.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="container-fluid">
        <div class="row">
            @foreach ($folder as $folldername)
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
                <div class="col-sm">
                    {{ $folldername->title }}
                </div>
            @endforeach
        </div>
    </div>
@endsection
