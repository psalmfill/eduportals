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
                    <form action="{{ route('staff.personalized_remarks') }}" method="GET" class="form">
                        @csrf
                        <input type="hidden" name="session" value="{{ getSettings()->current_session_id }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="exam" id="" class="form-control input-lg" required>

                                        <option value="">Select Exam</option>
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
                            <div class="col-md-2">
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
                                            <option>Select Section</option>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="container table">
                            <div class="row table-head border d-none d-md-flex text-center">
    
    
                                <div class="col-md-2 my-md-auto py-2">
                                    Passport
                                </div>
                                <div class="col-md-3 my-md-auto py-2">
                                    Name
                                </div>
                                <div class="col-md-2 my-md-auto py-2">
                                    Reg. No
                                </div>
                                <div class="col-md-5 my-md-auto py-2">
                                    Action
                                </div>
                            </div>
                            @foreach ($students as $item)
                                <div class="row striped border py-3 text-center align-middle">
                                    <div class="col-md-2 my-md-auto my-1">
                                        <img width="100" height="100" src="{{ $item->avatar }}" alt="image"
                                            class="rounded">
                                    </div>
                                    <div class="col-md-3 my-md-auto my-1">
                                        <div class="text-uppercase">{{ $item->full_name }}</div>
                                    </div>
                                    <div class="col-md-2 my-md-auto my-1 ">
                                        {{ $item->reg_no }}
                                    </div>
    
                                    <div class="col-md-5 my-md-auto my-1">
                                        <form action="{{ route('staff.personalized_remarks.store') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <input type="hidden" name="session" value="{{ $currentSession->id }}">
                                            <input type="hidden" name="exam" value="{{ $exam->id }}">
                                            <input type="hidden" name="class" value="{{ $currentClass->id }}">
                                            <input type="hidden" name="student" value="{{ $item->id }}">
                                            <input type="hidden" name="section" value="{{ $currentSection->id }}">
                                            <div class="input-group mb-2">
                                                @php
                                                $remark = $personalizedRemarks->firstWhere('student_id', $item->id)

                                                @endphp
                                                <textarea name="comment" id="" cols="30" rows="10" class="form-control" placeholder="Leave a personalized remark" required>{{ $remark?$remark->comment:null }}</textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
    
                        </div>
                    </div>
                </div>
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
        
    </script>
@endsection
