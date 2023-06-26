@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            @can('school_class_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="type/create">
                            {{ trans('global.add') }} {{ trans('cruds.schoolClass.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">
                            </th>
                            <th>
                                {{ trans('cruds.schoolClass.fields.name') }}
                            </th>
                            <th>
                                Color Code
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventsType as $key => $type)
                            <tr data-entry-id="{{ $type->id }}">
                                <td>
                                </td>
                                <td>
                                    {{ $type->name ?? '' }}
                                </td>
                                <td>
                                    {{ $type->color ?? '' }}
                                </td>

                                <td>
                                    @can('school_class_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="http://127.0.0.1:8000/admin/events/type/edit?id={{ $type->id }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('school_class_delete')
                                        <form action="http://127.0.0.1:8000/admin/events/type?id={{ $type->id }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
