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
                Pins Collections
            </a>
        </li>
    </ol>
@endsection

@section('content')
    @isset($pinCollections)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Pin Collections</h2>

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
                                        <th>Reference</th>
                                        <th>Pins</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pinCollections as $item)
                                        <tr class="">
                                            <td class="w-10">{{ $loop->index + 1 }}</td>
                                            <th>{{ $item->reference }}</th>
                                            <th>{{ $item->pins()->count() }}</th>
                                            <td class="center">
                                                <div class="btn-group">
                                                    <a href="{{ route('staff.pins.collections.show', $item->id) }}"
                                                        class="btn btn-info btn-sm"><i class="entypo-eye"></i> View</a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="{{ route('staff.pins.collections.download', $item->id) }}"
                                                        class="btn btn-info btn-sm"><i class="entypo-eye"></i> Download</a>
                                                </div>
                                                {{-- <form action="{{route('staff.deleteStudent')}}" id="delete-student" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{$item->id}}">
                                    </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th>S/N</th>
                                        <th>Reference</th>
                                        <th>Pins</th>
                                        <th>Action</th>
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
