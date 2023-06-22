@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- You are logged in! --}}
                        @if (auth()->user()->is_teacher)
                            <div class="row">
                                <div class="col-lg">
                                    <div class="card">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>School Class Information</strong>
                                            </li>
                                            @foreach ($classes as $class)
                                                <li class="list-group-item">{{ $class->name }} <span
                                                        class="badge badge-primary">{{ $class->campus }}</span> => Total
                                                    Students <span
                                                        class="badge badge-success">{{ $class->classUsers->count() }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="card">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>Assignment Information</strong></li>
                                            {{-- <li class="list-group-item">Unpublish Assignment: <span class="badge badge badge-warning">44</span>  Published Assignment <span class="badge badge-primary">99</span></li>
                                <li class="list-group-item"> --}}
                                            </li>
                                        </ul>
                                        <div class="accordion" id="accordionExample">

                                            <div class="card mb-0">
                                                <div class="card-header" id="headingOne">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button"
                                                            data-toggle="collapse" data-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Unpublish Assignment <span
                                                                class="badge badge-warning">{{ count($data['unpublish']) }}</span>
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            @foreach ($data['unpublish'] as $n => $d)
                                                                <li class="list-group-item">{{ $n + 1 }}-
                                                                    {{ $d->course->name }}: {{ $d->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left collapsed"
                                                            type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Published Assignment <span
                                                                class="badge badge-primary">{{ count($data['publish']) }}</span>
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            @foreach ($data['publish'] as $n => $d)
                                                                <li class="list-group-item">{{ $n + 1 }}-
                                                                    {{ $d->course->name }}: {{ $d->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col">

                                    <div class="card">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item active"><strong>Student Submitted Assignment</strong>
                                            </li>
                                            <li class="list-group-item">

                                                <table class="table table-sm display">
                                                    <thead>
                                                        <tr>
                                                            <td>No</td>
                                                            <td>Student Name</td>
                                                            <td>Assignment</td>
                                                            <td>Class</td>
                                                            <td>Campus</td>
                                                            <td>Submitted Date</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($assign_returns as $no => $assignment)
                                                            <tr>
                                                                <td>{{ $no + 1 }}</td>
                                                                <td>{{ $assignment->student->name }}</td>
                                                                <td>{{ $assignment->homework->name }}</td>
                                                                <td>{{ $assignment->student->class->name }}</td>
                                                                <td>{{ $assignment->student->class->campus }}</td>
                                                                <td>{{ $assignment->turnedindate->format('d-m-Y h:i A') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
