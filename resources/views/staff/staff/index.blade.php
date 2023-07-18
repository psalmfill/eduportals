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


                {{-- <table class="table table-bordered datatable mt-4" id="table-4">
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
                </table> --}}
                <div class="container">
                    <div class="row table-head border d-none d-md-flex font-weight-bold text-center">


                        <div class="col-md-1 my-md-auto py-2">
                            Passport
                        </div>
                        <div class="col-md-3 my-md-auto py-2">
                            Name
                        </div>
                        <div class="col-md-2 my-md-auto py-2">
                            Phone Number
                        </div>
                        <div class="col-md-2 my-md-auto py-2">
                            Email Address
                        </div>
                        <div class="col-md-2 my-md-auto py-2">
                            Address
                        </div>
                        <div class="col-md-2 my-md-auto py-2">
                            Action
                        </div>
                    </div>
                    @foreach ($staff as $item)
                        <div class="row striped border py-3 text-center align-middle">
                            <div class="col-md-1 my-md-auto my-1">
                                <img width="100" height="100" src="{{ $item->avatar }}" alt="image" class="rounded">
                            </div>
                            <div class="col-md-3 my-md-auto my-1 font-weight-bold">
                                <div class="text-secondary text-uppercase">{{ $item->name }}</div>
                            </div>
                            <div class="col-md-2 my-md-auto my-1 font-weight-bold">
                                {{ $item->phone_number }}
                            </div>
                            <div class="col-md-2 my-md-auto my-1">
                                {{ $item->email }}
                            </div>
                            <div class="col-md-2 my-md-auto my-2">
                                {{ $item->address }}
                            </div>
                            <div class="col-md-2 my-md-auto my-1">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('students.show', $item->id) }}" class="btn btn-info btn-sm mr-1">
                                        View</a>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <a href="{{ route('students.edit', $item->id) }}" class="btn btn-secondary btn-sm">
                                            Edit</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="mt-4 d-flex justify-content-center">

                    {!! $staff->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
