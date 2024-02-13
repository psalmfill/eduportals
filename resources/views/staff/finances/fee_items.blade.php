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
                Finance Management
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Fee Items
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Fee Items</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <div class="col-md-4">
                            <div class="well">
                                <h4 class="margin">{{ isset($feeItem) ? 'Edit' : 'Create' }} Fee Category</h4>
                                <hr>
                                @isset($feeItem)
                                    <form action="{{ route('staff.finances.feeItems.update', $feeItem->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" value="{{ old('name')?? $feeItem->name }}"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>

                                            <input type="text" value="{{ old('description')?? $feeItem->description }}" name="description"
                                                class="form-control">
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="amount">Amount</label>

                                            <input type="text" value="{{ old('amount')?? $feeItem->amount }}" name="amount"
                                                class="form-control">
                                            @error('amount')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('staff.finances.feeItems.store') }}" method="POST">
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
                                            <label for="description">Description</label>

                                            <input type="text" value="{{ old('description') }}" name="description"
                                                class="form-control">
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="amount">Amount</label>

                                            <input type="text" value="{{ old('amount') }}" name="amount"
                                                class="form-control">
                                            @error('amount')
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
                                    <th>Description</th>
                                    <th>Amount</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feeItems as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->amount }}</td>
                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                            <td>
                                                <form action="{{ route('staff.finances.feeItems.destroy', $item->id) }}" method="post"
                                                    class="form-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="">
                                                        <a href="{{ route('staff.finances.feeItems.edit', $item->id) }}"
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
                                    <th>Description</th>
                                    <th>Amount</th>
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
