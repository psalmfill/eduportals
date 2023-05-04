@extends('layouts.dashboard')


@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="#">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('staff.comment_result.grades') }}">
                <i class="entypo-users"></i>
                Comment Result Grades
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Grade</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">{{ isset($grade) ? 'Edit' : 'Create' }} Grade</h4>
                            <hr>
                            @isset($grade)
                                <form action="{{ route('staff.comment_result.gradesUpdate', $grade->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name</label>

                                        <input type="text" name="name" class="form-control" value="{{ $grade->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Remark</label>

                                        <input type="text" name="remark" class="form-control" value="{{ $grade->remark }}">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('staff.comment_result.gradesPost') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>

                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Remark</label>

                                        <input type="text" name="remark" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Create</button>
                                    </div>
                                </form>
                            @endisset

                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered  ">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->remark }}</td>
                                        <td>
                                            <form action="{{ route('staff.comment_result.gradesDestroy', $item->id) }}"
                                                method="post" class="form-inline">
                                                @csrf
                                                @method('delete')

                                                <div>
                                                    <a href="{{ route('staff.comment_result.gradesEdit', $item->id) }}"
                                                        class="btn btn-primary btn-sm icon-left  pull-left">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-danger btn-sm icon-left">
                                                        <i class="entypo-trash"></i>
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
    @endsection
