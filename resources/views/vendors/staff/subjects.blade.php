@extends('layouts.vendor')


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
                Assign Subjects
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Assign Subject</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            @isset($currentStaff)
                                <form action="{{ route('staff.classes.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <div class="form-group">
                                            <label for="name">Select Staff</label>
                                            <select class="form-control" name="staff" id="">
                                                <option value="{{ $currentStaff->id }}">{{ $currentStaff->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @foreach ($schoolClasses as $class)
                                            <div class="row" style="margin-bottom:2%;padding:2%">
                                                <div class="col-md-4">
                                                    <div>{{ $class->name }}</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="control-label">Sections</label>

                                                        <div class="">
                                                            @foreach ($class->sections as $item)
                                                                <div class="checkbox checkbox-replace">
                                                                    <input type="checkbox"
                                                                        name="sections[{{ $class->id }}][]"
                                                                        id="section-{{ $item->id }}"
                                                                        value="{{ $item->id }}"
                                                                        {{ App\Models\Staff::classSections($currentStaff->id, $class->id, 1)->contains($item) ? 'checked' : '' }}>
                                                                    <label>{{ $item->name }}</label>
                                                                </div>
                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('staff.assign_subjects.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Select Staff</label>
                                        <select class="form-control" name="staff" id="staff" required>
                                            <option value="">Select Staff</option>
                                            @foreach ($staff as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Select class</label>
                                        <select class="form-control" name="class" id="class" required>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Select Section</label>
                                        <select class="form-control" name="section" id="section" required>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Subjects</label>
                                        <div id="subjects">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Assign</button>
                                    </div>
                                </form>
                            @endisset

                        </div>
                    </div>
                    <div class="col-md-8">
                        <script type="text/javascript">
                            // jQuery( document ).ready( function( $ ) {
                            //     var $table4 = jQuery( "#table-4" );

                            //     $table4.DataTable();
                            // } );		
                        </script>

                        <table class="table table-bordered table-condensed" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Classes</th>
                                    <th>Sections</th>
                                    <th>Subjects</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffWithClasses as $staff)
                                    @php
                                        $uniqueClasses = $staff
                                            ->school_classes()
                                            ->wherePivot('school_id', getSchool()->id)
                                            ->get();
                                        $staffRowSpan = 0;
                                        $su = $uniqueClasses->sum(function ($c) use ($staff, &$staffRowSpan) {
                                            $classSections = App\Models\Staff::classSections($staff->id, $c->id, getSchool()->id);
                                            return $classSections->count();
                                        });
                                        $staffRowSpan = $uniqueClasses->count();
                                    @endphp
                                    <tr>
                                        <td rowspan="{{ $staffRowSpan }}">{{ $staff->name }}</td>
                                        @foreach ($staff->school_classes->unique() as $class)
                                            @php
                                                $classSubjects = $staff
                                                    ->subjects()
                                                    ->wherePivot('school_class_id', $class->id)
                                                    ->get();
                                                $classSections = App\Models\Staff::classSections($staff->id, $class->id, getSchool()->id);
                                            @endphp
                                            @if ($classSections->count() > 0)
                                                <td rowspan="{{ $classSections->count() }}">{{ $class->name }}</td>
                                                @foreach ($classSections as $section)
                                                    @php
                                                        $classSectionSubjects = $staff
                                                            ->subjects()
                                                            ->wherePivot('school_class_id', $class->id)
                                                            ->wherePivot('section_id', $section->id)
                                                            ->get();
                                                        $rowspan = $classSectionSubjects->count() > 0 ? $classSectionSubjects->count() : 1;
                                                    @endphp
                                                    <td>{{ $section->name }} </td>
                                                    <td>
                                                        @foreach ($classSectionSubjects as $sub)
                                                            {{ $sub->name }}{{ $loop->index == $classSectionSubjects->count() - 1 ? '' : ',' }}
                                                        @endforeach
                                                    </td>
                                    </tr>
                                @endforeach
                            @else
                                </tr>
                                @endif
                                @endforeach
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
        <script>
            $('#staff').change(function(e) {
                const staff_id = e.target.value;
                $('#subjects').html('');
                // show_loading_bar(65);
                //fetch class sections
                $.ajax({

                    url: BASE_URL + "/api/staff/" + staff_id + "/classes",
                }).done(function(data) {
                    let html = '<option>Select Class</option>'
                    data.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#class').html(html);
                    // show_loading_bar(100);
                });
            })
            $('#class').change(function(e) {
                const class_id = e.target.value;
                const staff_id = $('#staff').val();
                $('#subjects').html('');
                // show_loading_bar(65);
                //fetch class sections
                $.ajax({

                    url: BASE_URL + "/api/staff/" + staff_id + "/classes/" + class_id + "/sections",
                }).done(function(data) {
                    let html = '<option>Select Section</option>'
                    data.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#section').html(html);
                    // show_loading_bar(100);
                });
            })
            $('#section').change(function(e) {
                const class_id = $('#class').val();
                const section_id = e.target.value;
                $('#subjects').html('');
                // show_loading_bar(65);
                //fetch class sections
                $.ajax({

                    url: BASE_URL + "/api/classes/" + class_id + "/sections/" + section_id + "/subjects",
                }).done(function(data) {
                    let html = ''
                    data.forEach(function(el) {

                        $('#subjects').html(html);
                        // console.log(el.id)
                        html += '<div ><input type="checkbox" name="subjects[]" id="subject-' + el.id +
                            '" value="' + el.id + '"> <label>' + el.name + '</label></div>'

                    })
                    $('#subjects').html(html);


                    // show_loading_bar(100);
                });
            })
        </script>
    @endsection
