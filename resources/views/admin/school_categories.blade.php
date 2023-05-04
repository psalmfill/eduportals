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
                School Category
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Categories</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">{{ isset($category) ? 'Edit' : 'Create' }} Category</h4>
                            <hr>
                            @isset($category)
                                <form action="{{ route('school-categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="">Category Name</label>
                                        <input type="text" value="{{ $category->name }}" name="name" class="form-control">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('school-categories.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Category Name</label>
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
                    <div class="col-md-8">
                        <script type="text/javascript">
                            // jQuery( document ).ready( function( $ ) {
                            //     var $table4 = jQuery( "#table-4" );

                            //     $table4.DataTable();
                            // } );		
                        </script>

                        <table class="table table-bordered table-condensed" id="table-4">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <form action="{{ route('school-categories.destroy', $item->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <a href="/a" class="btn btn-success"><i class="entypo-eye"></i>
                                                        view</a>
                                                    <a href="{{ route('school-categories.edit', $item->id) }}"
                                                        class="btn btn-info"><i class="entypo-pencil"></i> Edit</a>
                                                    <button class="btn btn-danger"><i
                                                            class="entypo-trash"></i>Delete</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
    @endsection
