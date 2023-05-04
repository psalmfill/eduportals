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
            <a href="#">
                <i class="entypo-users"></i>
                Subjects
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Subjects</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <div class="col-md-4">
                            <div class="well">
                                <h4 class="margin">{{ isset($subject) ? 'Edit' : 'Create' }} Subject</h4>
                                <hr>
                                @isset($subject)
                                    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" value="{{ $subject->name }}"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Code</label>

                                            <input type="text" name="code" value="{{ $subject->code }}"
                                                class="form-control">
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('subjects.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" value="{{ old('name') }}" name="name"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Code</label>

                                            <input type="text" value="{{ old('code') }}" name="code"
                                                class="form-control">
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">Create</button>
                                        </div>
                                    </form>
                                @endisset

                            </div>
                        </div>
                    @endif
                    <div class="col-md-8">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table4 = jQuery("#table-4");

                                $table4.DataTable();
                            });
                        </script>

                        <table class="table  table-boarder datatable dataTable no-footer" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->code }}</td>
                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                            <td>


                                                {{-- <a href="{{route('subjects.destroy',$item->id)}}" class="btn btn-danger btn-sm icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                            </a> --}}
                                                <form action="{{ route('subjects.destroy', $item->id) }}" method="post"
                                                    class="form-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="btn-group">
                                                        <a href="{{ route('subjects.edit', $item->id) }}"
                                                            class="btn btn-info btn-sm icon-left  pull-left">
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
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
    @endsection
