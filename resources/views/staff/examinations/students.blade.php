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
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Result</h3>
                    <form action="{{ route('staff.results.view') }}" class="form">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="session" id="" class="form-control input-lg" required>
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}"
                                                {{ isset($currentSession) && $currentSession->id == $session->id ? 'selected' : '' }}>
                                                {{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="exam" id="" class="form-control input-lg" required>

                                        <option value="exam">Select Exam</option>
                                        @foreach ($exams as $type)
                                            <option value="{{ $type->id }}"
                                                {{ isset($exam) && $exam->id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg" required>
                                        @isset($sections)
                                            @foreach ($sections as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ $sec->id == $currentSection->id ? 'selected' : '' }}>
                                                    {{ $sec->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Select Section</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @isset($students)
        <div class="card">
            <div class="card-body">
                <h2>Class Results</h2>
                <hr>
                @if ($students->count() > 0)
                    {{-- <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-4">
                                    <thead>
                                        <th rowspan="">S/N</th>
                                        <th>Avatar</th>
                                        <th rowspan="">Reg No</th>
                                        <th rowspan="">Name</th>
                                        <th rowspan="">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td class="text-center p-0"> <img width="50" height="50"
                                                        src="{{ $item->avatar }}" alt="image" class="img-fluid">
                                                </td>
                                                <td>{{ $item->reg_no }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>
                                                    <form action="{{ route('staff.student-result') }}" class="form-horizontal">
                                                        <input type="hidden" name="session" value="{{ $currentSession->id }}">
                                                        <input type="hidden" name="exam" value="{{ $exam->id }}">
                                                        <input type="hidden" name="class" value="{{ $currentClass->id }}">
                                                        <input type="hidden" name="student" value="{{ $item->id }}">
                                                        <input type="hidden" name="section" value="{{ $currentSection->id }}">
                                                        <div class="input-group">
                                                            <select name="type" class="form-control mr-1" id="">
                                                                <option value="standand">Standard results</option>
                                                                <option value="comment">comment results</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-primary btn-sm">View</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div> --}}

                    <div class="container table">
                        <div class="row table-head border d-none d-md-flex text-center">


                            <div class="col-md-2 my-md-auto py-2">
                                Passport
                            </div>
                            <div class="col-md-4 my-md-auto py-2">
                                Name
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Reg. No
                            </div>
                            <div class="col-md-4 my-md-auto py-2">
                                Action
                            </div>
                        </div>
                        @foreach ($students as $item)
                            <div class="row striped border py-3 text-center align-middle">
                                <div class="col-md-2 my-md-auto my-1">
                                    <img width="100" height="100" src="{{ $item->avatar }}" alt="image"
                                        class="rounded">
                                </div>
                                <div class="col-md-4 my-md-auto my-1">
                                    <div class="text-uppercase">{{ $item->full_name }}</div>
                                </div>
                                <div class="col-md-2 my-md-auto my-1 ">
                                    {{ $item->reg_no }}
                                </div>

                                <div class="col-md-4 my-md-auto my-1">
                                    <form action="{{ route('staff.student-result') }}" class="form-horizontal">
                                        <input type="hidden" name="session" value="{{ $currentSession->id }}">
                                        <input type="hidden" name="exam" value="{{ $exam->id }}">
                                        <input type="hidden" name="class" value="{{ $currentClass->id }}">
                                        <input type="hidden" name="student" value="{{ $item->id }}">
                                        <input type="hidden" name="section" value="{{ $currentSection->id }}">
                                        <div class="input-group">
                                            <select name="type" class="form-control mr-1" id="">
                                                <option value="standand">Standard results</option>
                                                <option value="comment">Comment results</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">View</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-4 d-flex justify-content-center">

                            {!! $students->withQueryString()->links() !!}

                        </div>

                    </div>

                    <br>
                    <div class="clearfix"></div>
                    <hr>
                    {{-- ALLOW BULK RESULT PRINTING --}}
                    {{-- @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                            <div class="d-flex justify-content-around">
                                <form action="{{ route('staff.download-result') }}" class="form-inline">
                                    <input type="hidden" name="session" value="{{ $currentSession->id }}">
                                    <input type="hidden" name="exam" value="{{ $exam->id }}">
                                    <input type="hidden" name="class" value="{{ $currentClass->id }}">
                                    <input type="hidden" name="section" value="{{ $currentSection->id }}">
                                    <input type="hidden" name="page" value="{{ $students->currentPage() }}">
                                    <select name="type" class="form-control" id="">
                                        <option value="standand">Standard results</option>
                                        <option value="comment">comment results</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Download page Result</button>
                                </form>
                            </div>
                        @endif --}}
                @else
                    <div class="alert alert-info text-center">No Result Available at the moment.</div>
                @endif
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
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
                show_loading_bar(100);
            });
        })
    </script>
@endsection
