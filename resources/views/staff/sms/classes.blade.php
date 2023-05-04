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
                Marks Register
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('staff.sms.classes.compose') }}" method="get" class="form">
                <div class="row">
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
                                    <option>Select Section</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block btn-lg"><i class="entypo-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @isset($students)
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('staff.sms.classes.send') }}" method="post">
                    @csrf
                    <input type="hidden" name="class" value="{{ $currentClass->id }}">
                    <input type="hidden" name="section" value="{{ $currentSection->id }}">
                    <input type="hidden" name="phones" value="{{ implode(',', $phone_numbers) }}">
                    <br>
                    <div class="card col-md-8">

                        <div class="form-group">
                            <label for="">Phone Numbers ({{ count($phone_numbers) }})</label>
                            <textarea class="form-control" placeholder="" disabled>{{ implode(',', $phone_numbers) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control" rows="3" placeholder=""></textarea>
                        </div>
                        <button class="btn btn-primary  btn-lg"><i class="fa fa-envelope"></i> Send</button>
                    </div>

                </form>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
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
                // show_loading_bar(100);
            });
        })
        $('#section').change(function(e) {
            const section_id = e.target.value;
            const class_id = $('#class').val();
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + "/subjects",
            }).done(function(data) {
                console.log(data)
                let html = '<option>Select Subject</option>'
                data.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#subject').html(html);
                // show_loading_bar(100);
            });
        })

        function clearMarks(e) {
            let r = confirm('Are you sure you want to clear marks. \nThis action is irreversible')
            if (r) {
                $(document).find('#clear-marks-form').submit()
            }
        }
    </script>
@endsection
