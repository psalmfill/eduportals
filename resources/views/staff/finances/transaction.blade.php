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
            <h3>Transaction</h3>

            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-12">

                        <div class="">
                            <h5 class="mb-4">Transaction Information</h5>
                            <table class="table table-striped table-info -sm">

                                <tr>
                                    <td>Date</td>
                                    <td>{{ $transaction->created_at->format('Y, F d') }}</td>
                                </tr>
                                <tr>
                                    <td>Session</td>
                                    <td>{{ $transaction->session->name }}</td>
                                </tr>

                                <tr>
                                    <td>Term</td>
                                    <td>{{ $transaction->term->name }}</td>
                                </tr>

                                <tr>
                                    <td>Reference</td>
                                    <td>{{ $transaction->reference }}</td>
                                </tr>
                                <tr>
                                    <td>Payment Channel</td>
                                    <td>{{ $transaction->channel }}</td>
                                </tr>
                                <tr>
                                    <td>Paid By</td>
                                    <td>{{ $transaction->channel == 'fee' ? $transaction->transactable->student->full_name : '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Payment Channel</td>
                                    <td>{{ $transaction->channel }}</td>
                                </tr>
                                @if ($transaction->channel == 'expenditure')
                                    <tr>
                                        <td>Title</td>
                                        <td>{{ $transaction->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>{{ $transaction->description }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Payment Type</td>
                                    <td>{{ $transaction->type }}</td>
                                </tr>
                                <tr>
                                    <td>Payment Amount</td>
                                    <td>NGN{{ $transaction->amount }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $transaction->status }}</td>
                                </tr>
                                <tr>
                                    <td>Processed By</td>
                                    <td>{{ $transaction->staff ? $transaction->staff->full_name : '' }}</td>
                                </tr>


                            </table>
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
            $('#section').change(function(e) {
                const section_id = e.target.value;
                const class_id = $('#class').val()
                // show_loading_bar(65);
                //fetch class sections
                console.log(section_id, BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id +
                    '/students');

                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + '/students',
                }).done(function(data) {
                    console.log(data)
                    let html = '<option>Select Students</option>'
                    data.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.full_name + ' (' + el.reg_no +
                            ')' + '</option>'
                    })


                    $('#students').html(html);
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
                        html += '<option value="' + el.id + '">' + el.name +
                            '</option>'
                    })


                    $('#section').html(html);
                    // show_loading_bar(100);
                });
            })
        </script>
    @endsection
