@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/xzoom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&display=swap" rel="stylesheet">
    <style>
        .khmer_os {
            font-family: 'Noto Sans Khmer', sans-serif;
            font-size: 130%;
        }
    </style>
@endsection

@section('content')
    @can('school_class_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.course.create') }}">
                    {{ trans('global.add') }} Course
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            <form name="frmcampus" method="get" action="{{ route('admin.course.index') }}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        Course {{ trans('global.list') }}
                    </div>

                    <div class="col">
                        <div class="form-group row">
                            <label class="required col-sm-3 col-form-label" for="class_id">Category</label>
                            <div class="col-sm-8">
                                <select class="custom-select" name="filter_category" id="filter_category"
                                    onchange="document.forms['frmcampus'].submit()">
                                    @foreach ($categories as $id => $category)
                                        <option value="{{ $category }}"
                                            {{ old('filter_category') == $category ? 'selected' : '' }}
                                            {{ $category == $current_filter['category'] ? 'selected' : '' }}>{{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col text-right">
                        <div class="form-group row">
                            <label class="required col-sm-3 col-form-label" for="class_id">Language</label>
                            <div class="col-sm-8">
                                <select class="custom-select" name="filter_language" id="filter_language"
                                    onchange="document.forms['frmcampus'].submit()">
                                    @foreach ($languages as $id => $language)
                                        <option value="{{ $language }}"
                                            {{ old('filter_language') == $language ? 'selected' : '' }}
                                            {{ $language == $current_filter['language'] ? 'selected' : '' }}>{{ $language }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                {{ trans('cruds.schoolClass.fields.id') }}
                            </th>
                            <th>
                                Thumbnail
                            </th>
                            <th>
                                Course
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Language Type
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $key => $course)
                            <tr data-entry-id="{{ $course->id }}" bgcolor="{{ $course->color ?? '#FFF' }}">
                                <td>

                                </td>
                                <td>
                                    {{ $course->id ?? '' }}
                                </td>
                                <td>
                                    <div class="xzoom-thumbs text-left">
                                        @if (!empty($course->image))
                                            <img src="{{ asset('storage/image/' . $course->image) }}"
                                                class="xzoom-gallery img-thumbnail btn btn-outline-primary"
                                                id="img_thumbnail" xpreview="{{ asset('storage/image' . $course->image) }}"
                                                style="height: 100px !important">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="btn btn-outline-primary"
                                                height="100px">
                                        @endif
                                    </div>
                                </td>
                                <td class="khmer_os">
                                    {{ $course->name ?? '' }}
                                </td>
                                <td>
                                    {{ $course->description ?? '' }}
                                </td>

                                <td>
                                    {{-- @foreach ($course->class as $class)
                                     <span class="badge badge-success">{{ $class->name }}-{{ $class->campus }}</span>
                                 @endforeach --}}
                                    {{ $course->category ?? '' }}
                                </td>
                                <td>
                                    {{ $course->language ?? '' }}
                                </td>

                                <td>
                                    @can('course')
                                        {{-- <a class="btn btn-xs btn-primary" href="{{ route('admin.course.show', $course->id) }}">
                                        {{ trans('global.view') }}
                                    </a> --}}

                                        <a class="btn btn-xs btn-info" href="{{ route('admin.course.edit', $course->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>

                                        <form action="{{ route('admin.course.destroy', $course->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
@section('scripts')
    @parent
    <script src="{{ asset('js/xzoom.min.js') }}"></script>
    <script src="{{ asset('js/magnific-popup.js') }}"></script>
    <script src="{{ asset('js/jquery.hammer.min.js') }}"></script>
    <script>
        $(function() {

            $('.xzoom-gallery').bind('click', function(event) {
                var div = $(this).parents('.xzoom-thumbs');
                // var xzoom = $(this).data('xzoom');
                // xzoom.closezoom();
                // var gallery = xzoom.gallery().cgallery;
                // var i, images = new Array();
                // for (i in gallery) {
                //     images[i] = {src: gallery[i]};
                // }
                images = new Array();

                var img_length = div.find('img').length;
                for (i = 0; i < img_length; i++)
                    images[i] = {
                        src: div.find('img').eq(i).attr("src")
                    };
                $.magnificPopup.open({
                    items: images,
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
                event.preventDefault();
            });

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('school_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan


            $.extend(true, $.fn.dataTable.defaults, {
                //order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
