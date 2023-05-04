@extends('layouts.admin')


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
                Roles
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Roles</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">{{ isset($role) ? 'Edit' : 'Create' }} Role</h4>
                            <hr>
                            @isset($role)
                                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name</label>

                                        <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('admin.roles.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>

                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Create</button>
                                    </div>
                                </form>
                            @endisset

                        </div>
                    </div>
                    <div class="col-md-8">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table4 = jQuery("#table-4");

                                $table4.DataTable();
                            });
                        </script>

                        <table class="table  table-striped datatable dataTable no-footer" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.roles.edit', $item->id) }}"
                                                class="btn btn-info btn-sm btn-icon icon-left  pull-left">
                                                <i class="entypo-key"></i>
                                                Permissions
                                            </a>
                                            <a href="{{ route('admin.roles.edit', $item->id) }}"
                                                class="btn btn-primary btn-sm btn-icon icon-left  pull-left">
                                                <i class="entypo-pencil"></i>
                                                Edit
                                            </a>

                                            {{-- <a href="{{route('terms.destroy',$item->id)}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-cancel"></i>
                                    Delete
                            </a> --}}
                                            <form action="{{ route('admin.roles.destroy', $item->id) }}" method="post"
                                                class="form-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm btn-icon icon-left">
                                                    <i class="entypo-trash"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
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
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
    @endsection
