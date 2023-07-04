@extends('layouts.admin')
@section('styles')
    <style>
        .card {
            height: fit-content;
            display: flex;
            flex-direction: column;
            padding: 1rem 1rem 2rem;
            background: #f8f3e8;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2), 0 0 40px rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .card>img {
            width: 100%;
            height: auto;
            aspect-ratio: 600/300;
        }

        .card>h2 {
            margin-top: 1rem;
            font-family: "Kalam", cursive;
            font-weight: normal;
            font-size: 2rem;
            color: #4a4a7d;
            text-align: center;
        }

        .card>p {
            font-family: "Kalam", cursive;
            font-size: 1rem;
            color: #5e5e89;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    @can('school_class_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.gallary.create') }}">
                    Add Gallary
                </a>
            </div>
        </div>
    @endcan
    @can('school_class_create')
        <div class="d-flex flex-wrap">
            @foreach ($gallary as $gallarysss)
                <a class="btn" href="{{ route('admin.gallary.edit', $gallarysss->id) }}"
                    style="background-color: rgb(128, 132, 132)">
                    {{ $gallarysss->name }}
                </a>
            @endforeach
        </div>
    @endcan
@endsection
