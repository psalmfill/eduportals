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
            <a href="{{ route('schools.index') }}">
                <i class="fa fa-building"></i>
                Schools
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Schools</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="text-uppercase text-center table table-bordered  " id="table-"
                            style="white-space:nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">S/N</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone Number</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Country</th>
                                    <th class="text-center">State</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schools as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-lowercase">{{ $item->code }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->country }}</td>
                                        <td>{{ $item->state }}</td>
                                        <td>{{ $item->city }}</td>
                                        <td>{{ $item->active ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <form action="{{ route('schools.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <a href="http://{{ strtolower($item->code) . '.' . env('BASE_URL') }}"
                                                        target="_blank" class="btn btn-success btn-sm"><i
                                                            class="entypo-eye"></i>
                                                        view</a>
                                                    <a href="{{ route('schools.edit', $item->id) }}"
                                                        class="btn btn-info btn-sm"><i class="entypo-pencil"></i> Edit</a>
                                                    <button class="btn btn-danger btn-sm"><i
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
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
