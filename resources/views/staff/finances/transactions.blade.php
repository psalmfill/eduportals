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
                Classes
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Finance Management</h1>
            <h3>Transactions</h3>

            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-12 table-responsive">

                        <table class="table table-sm  table-bordered datatable dataTable no-footer" id="table-4">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Reference No</th>
                                    <th>Session</th>
                                    <th>Term</th>
                                    <th>Type</th>
                                    <th>Channel</th>
                                    <th>Amount</th>
                                    <th>Recorded By</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->session->name }}</td>
                                        <td>{{ $item->term->name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->channel }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->staff ? $item->staff->full_name : '' }}</td>

                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                            <td>

                                                <div class="btn-group">
                                                    <a href="{{ route('staff.finances.fee', $item->id) }}" target="_blank"
                                                        class="btn btn-info btn-sm ">
                                                        <i class="entypo-eye"></i>
                                                        View
                                                    </a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
        <script>
            $('#class').change(function(e) {
                const class_id = e.target.value;
                // show_loading_bar(65);
                //fetch class sections
                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + '/sections',
                }).done(function(data) {
                    let html = '<option>Select Section</option>'
                    data.sections.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#section').html(html);
                    // show_loading_bar(100);
                });
            })
            $(document).load(function(e) {
                const class_id = $('#class').val;
                // show_loading_bar(65);
                //fetch class sections
                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + '/sections',
                }).done(function(data) {
                    let html = '<option>Select Section</option>'
                    data.sections.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#section').html(html);
                    // show_loading_bar(100);
                });
            })
        </script>
    @endsection
