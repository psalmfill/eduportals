@extends('layouts.student')

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
    @isset($assignments)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <h2>Assignments</h2>
                    <div class="container table">
                        <div class="row table-head border d-none d-md-flex font-weight-bold">
                            <div class="col-md-3 my-md-auto py-2">
                                Title
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Class
                            </div>

                            <div class="col-md-2 my-md-auto py-2">
                                Section
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Subject
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Action
                            </div>
                        </div>
                        @if ($assignments->count() > 0)
                            @foreach ($assignments as $item)
                                <div class="row striped border py-3 align-middle">

                                    <div class="col-md-3 my-md-auto my-1">
                                        <div class="text-uppercase">{{ $item->title }}</div>
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->school_class->name }}
                                    </div>

                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->section->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->subject->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-1">
                                        <div class="d-flex">

                                            <a href="{{ route('student.assignments.show', $item->id) }}"
                                                class="btn btn-info btn-sm ">
                                                View</a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                {!! $assignments->links() !!}
                            </div>
                        @else
                            <div class="col-md-12 my-md-auto py-2">
                                <h3 class="text-center alert alert-info">
                                    Nothing to show here
                                </h3>

                                @if (!(user() instanceof \App\Models\Student))
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('assignments.create') }}" class="btn btn-success">Setup
                                            Assignment</a>
                                    </div>
                                @endif
                            </div>
                        @endisset
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
