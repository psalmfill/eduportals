@extends('layouts.dashboard')


@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{ route('staff.dashboard') }}">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Staff
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Staff</h3>
            <div class="container-flui d-flex justify-content-end">

                <a href="{{ route('staff.create') }}" class="btn btn-primary pull-right">Add Staff</a>
            </div>
            <br />
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    var $table4 = jQuery("#table-4");

                    $table4.DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                        ]
                    });
                });
            </script>
            <div class="table-responsive">


                <table class="table table-bordered datatable mt-4" id="table-4">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td><img height="50" class="img-circle" src="{{ asset($item->avatar) }}" alt="">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->address_1 }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('staff.edit', $item->id) }}"
                                            class="btn btn-info btn-sm mr-1">Edit</a>
                                        <a href="{{ route('staff.show', $item->id) }}"
                                            class="btn btn-secondary btn-sm mr-1">View</a>
                                        <button onclick="$(this).parent().find('form').submit()"
                                            class="btn btn-danger btn-sm">Delete</button>
                                        <form action="{{ route('staff.destroy', $item->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                        <tr>
                            <th>SN</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
