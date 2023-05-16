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
            <h3>Record Expenditure</h3>

            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-12">

                        @isset($expenditure)
                            <form action="{{ route('staff.finances.save_expenditure') }}" class="form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Academic Session</label>
                                            <select name="session" id="" class="form-control input-lg" required>
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}"
                                                        {{ $expenditure->academic_session_id == $session->id ? 'selected' : '' }}>
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
                                                        {{ $expenditure->term_id == $term->id ? 'selected' : '' }}>
                                                        {{ $term->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input name="amount" type="number" class="form-control" placeholder="Amount Paid"
                                                value="{{ old('amount') ?? $fee->amount }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-primary">Save Record</button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('staff.finances.save_expenditure') }}" class="form" method="post">
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
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input name="date" type="date" class="form-control" placeholder="date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input name="title" type="text" class="form-control" placeholder="Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input name="amount" type="number" class="form-control" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
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
