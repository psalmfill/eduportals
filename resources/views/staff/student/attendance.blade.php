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
                Attendance
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Result</h3>
                    <form action="" method="GET" class="form">
                        {{-- @csrf --}}
                        <div class="row">
                            {{-- <div class="col-md-2">
                        <div class="form-group">
                            <select name="session" id="" class="form-control input-lg">
                                <option value="">Select Session</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->id }}"
                                        {{ isset($currentSession) && $currentSession->id == $session->id ? 'selected' : '' }}>
                                        {{ $session->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                            {{-- <div class="col-md-2">
                        <div class="form-group">
                            <select name="term" id="" class="form-control input-lg">
                                <option value="">Select Term</option>
                                @foreach ($terms as $term)
                                    <option value="{{ $term->id }}"
                                        {{ isset($currentTerm) && $currentTerm->id == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="class" id="class" class="form-control input-lg" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ isset($currentClass) && $currentClass->id == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg" required>
                                        @isset($sections)
                                            @foreach ($sections as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ $sec->id == $currentSection->id ? 'selected' : '' }}>{{ $sec->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Select Section</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Select Date"
                                        class="form-control datepicker form-control-sm"
                                        value="{{ old('date_of_birth') ?? request()->date }}" data-start-view="1">
                                    @error('date')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block"><i class="entypo-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @isset($students)
        <div class="card mt-2">
            <div class="card-body">
                <h2>Attendance</h2>
                <hr>
                @if ($students->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="POST">
                                @csrf
                                <div class="form-group pull-right">
                                    <label for="">
                                        <input type="checkbox" name="holiday" id=""> Holiday
                                    </label>
                                </div><br><br>
                                {{-- <script type="text/javascript">
                jQuery( document ).ready( function( $ ) {
                    var $table4 = jQuery( "#table-4" );
                    
                    $table4.DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                        ]
                    } );
                } );		
                </script> --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed datatable" id="table-4"
                                        style="empty-cells:show">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="">Passport</th>
                                                <th rowspan="">Reg No</th>
                                                <th rowspan="">Name</th>
                                                <th>Present</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $item)
                                                <tr>
                                                    <td class="text-center"> <img width="50" height="50"
                                                            src="{{ $item->avatar }}" alt="image" class="rounded"></td>
                                                    <td>{{ $item->reg_no }}</td>
                                                    <td>{{ $item->full_name }}</td>
                                                    <td><input type="checkbox" name="students[]" value="{{ $item->id }}"
                                                            id=""
                                                            @php
$at = App\Models\Attendance::getAttendance($item->id,$date);
                                    if($at && $at->present) echo 'checked'; @endphp>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <br />

                                <button class="btn btn-success pull-right ">Save</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">No Result Available at the moment.</div>
                @endif
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    {{-- <script src="{{asset('assets/js/datatables/datatables.js')}}"></script> --}}
    <script>
        $('#class').change(function(e) {
            const class_id = e.target.value;
            console.log(class_id);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections',
            }).done(function(data) {
                let html = '<option>Select Section</option>'
                data.sections.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#section').html(html);
                //    show_loading_bar(100);
            });
        })
    </script>
@endsection
