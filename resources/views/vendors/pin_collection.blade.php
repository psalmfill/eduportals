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
            <a href="#">
                <i class="entypo-users"></i>
                Pins Collection
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card bg-secondary mb-2">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Collection {{ $pinCollection->reference }} - Pins</h3>
                </div>
                <div class="btn-group">
                    <a href="{{ route('vendor.pins.collections.download', $pinCollection->id) }}"
                        class="btn btn-info btn-sm">Download</a>
                </div>
            </div>
        </div>
    </div>
    @isset($pinCollection)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <br />
                            {{-- <script type="text/javascript">
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
                            </script> --}}

                            <table class="table table-bordered datatable mt-4" id="table-4">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Code</th>
                                        <th>Is Used</th>
                                        <th>Used By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pinCollection->pins as $item)
                                        <tr class="">
                                            <td class="w-10">{{ $item->serial_number }}</td>

                                            <th>{{ $item->code }}</th>
                                            <th>{{ $item->is_used ? 'Yes' : 'No' }}</th>
                                            <th>{{ $item->student ? $item->student->name : null }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th>S/N</th>
                                        <th>Code</th>
                                        <th>Is Used</th>
                                        <th>User</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
