@extends('layouts.vendor')


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
                                        <td>{{ $item->active ? 'Active' : 'Inactive' }}</td>
                                        <td>

                                            <div class="btn-group">
                                                <a href="http://{{ strtolower($item->code) . '.' . env('BASE_URL') }}"
                                                    target="_blank" class="btn btn-secondary btn-sm"><i
                                                        class="entypo-eye"></i>
                                                    Visit</a>
                                                <a href="{{ route('vendor.schools.show', $item->id) }}"
                                                    class="btn btn-success btn-sm"><i class="entypo-eye"></i>
                                                    view</a>
                                                <a href="{{ route('vendor.schools.edit', $item->id) }}"
                                                    class="btn btn-info btn-sm"><i class="entypo-pencil"></i> Edit</a>

                                            </div>
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
