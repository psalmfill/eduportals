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
                Sections
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Section</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <div class="col-md-4">
                            <div class="well">
                                <h4 class="margin">{{ isset($section) ? 'Edit' : 'Create' }} Section</h4>
                                <hr>
                                @isset($section)
                                    <form action="{{ route('sections.update', $section->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" value="{{ $section->name }}"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('sections.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" class="form-control">
                                            @error('name')
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
                    <div class="col-md-6">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table4 = jQuery("#table-4");

                                $table4.DataTable();
                            });
                        </script>

                        <table class="table  table-bordered datatable dataTable no-footer" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                            <td>

                                                {{-- <a href="{{route('sections.destroy',$item->id)}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                            </a> --}}
                                                <form action="{{ route('sections.destroy', $item->id) }}" method="post"
                                                    class="form-inline">
                                                    @csrf
                                                    @method('delete')

                                                    <div class="">
                                                        <a href="{{ route('sections.edit', $item->id) }}"
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
