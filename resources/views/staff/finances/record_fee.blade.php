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
            <h3>Record Fees</h3>

            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-12">

                        @isset($fee)

                            <form action="{{ route('staff.finances.saveFee') }}" class="form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Academic Session</label>
                                            <select name="session" id="" class="form-control input-lg" required>
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}"
                                                        {{ $fee->academic_session_id == $session->id ? 'selected' : '' }}>
                                                        {{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="">Term</label>
                                            <select name="term" id="" class="form-control input-lg" required>
                                                <option value="">Select Term</option>
                                                @foreach ($terms as $term)
                                                    <option value="{{ $term->id }}"
                                                        {{ $fee->term_id == $term->id ? 'selected' : '' }}>
                                                        {{ $term->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Class</label>
                                            <select name="class" id="class" class="form-control input-lg" required>
                                                <option>Select Class</option>

                                                @foreach ($classes as $sec)
                                                    <option value="{{ $sec->id }}"
                                                        {{ $fee->school_class_id == $sec->id ? 'selected' : '' }}>
                                                        {{ $sec->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Section</label>
                                            <select name="section" id="section" class="form-control input-lg" required>
                                                <option value="{{ $fee->student->section->id }}" selected>
                                                    {{ $fee->student->section->name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="student" id="students" class="form-control input-lg" required>

                                                <option value="{{ $fee->student->id }}" selected>
                                                    {{ $fee->student->full_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($feeItems as $feeItem)
                                        <div class="col-md-6">
                                            <div class="checkbox checkbox-replace">
                                                <input type="checkbox" name="feeItems[]" class="mt-1"
                                                    id="section-{{ $feeItem->id }}" value="{{ $feeItem->id }}">
                                                <label>{{ $feeItem->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Total Fee Amount</label>
                                            <input id="total-amount" name="total_fee" type="number" class="form-control"
                                                placeholder="Total Fee Amount" value="{{ $fee->amount }}" </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Amount Paid</label>
                                            <input name="amount_paid" type="number" class="form-control"
                                                placeholder="Amount Paid"
                                                value="{{ $fee->amount - $fee->transactions()->sum('amount') }}" </div>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <button class="btn btn-primary">Save Record</button>
                                    </div>
                            </form>
                        @else
                            <form action="{{ route('staff.finances.saveFee') }}" class="form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Academic Session</label>
                                            <select name="session" id="" class="form-control input-lg" required>
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}">
                                                        {{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="">Term</label>
                                            <select name="term" id="" class="form-control input-lg" required>
                                                <option value="">Select Term</option>
                                                @foreach ($terms as $term)
                                                    <option value="{{ $term->id }}">
                                                        {{ $term->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Class</label>
                                            <select name="class" id="class" class="form-control input-lg" required>
                                                <option>Select Class</option>

                                                @foreach ($classes as $sec)
                                                    <option value="{{ $sec->id }}">
                                                        {{ $sec->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Section</label>
                                            <select name="section" id="section" class="form-control input-lg" required>

                                                <option>Select Section</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="student" id="students" class="form-control input-lg" required>
                                                @isset($students)
                                                    @foreach ($students as $sec)
                                                        <option value="{{ $sec->id }}">
                                                            {{ $sec->full_name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option>Select Students</option>
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <label class="d-block" for="">Fees</label>
                                <div class="row">

                                    @foreach ($feeItems as $feeItem)
                                        <div class="col-md-6">
                                            <div class="checkbox checkbox-replace">
                                                <input type="checkbox" name="feeItems[]" class="mt-1 cat"
                                                    data-amount="{{ $feeItem->amount }}"
                                                    id="section-{{ $feeItem->id }}" value="{{ $feeItem->id }}">
                                                <label>{{ $feeItem->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Total Fee Amount</label>
                                            <input id="total-amount" name="total_fee" type="number" class="form-control"
                                                placeholder="Total Fee Amount">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Amount Paid</label>
                                            <input id="amount-paid" name="amount_paid" type="number" class="form-control"
                                                placeholder="Amount Paid">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-primary">Save Record</button>
                                </div>
                            </form>
                        @endisset
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

                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + '/students',
                }).done(function(data) {
                    let html = '<option>Select Students</option>'
                    data.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.full_name + ' (' + el.reg_no +
                            ')' + '</option>'
                    })


                    $('#students').html(html);
                    // show_loading_bar(100);
                });
                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + '/fee-categories',
                }).done(function(data) {
                   let total =0
                    data.forEach(function(el) {
                        $('#section-'+el.id).prop('checked',true);
                        total +=el.amount *1
                    })
                    $('#total-amount').val(total);
                    $('#amount-paid').val(total);


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
