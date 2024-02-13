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
                Finance Management
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Fees Setup
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Fee Setup</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <div class="col-md-4">
                            <div class="well">
                                    <form action="{{ route('staff.finances.feeSetup.save') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Class</label>
                                            <select name="class" id="class" class="form-control">
                                                <option value="">Select Class</option>
                                                @foreach ($school_classes as $item)
                                                    <option value="{{ $item->id }}"
                                                        @isset($schoolClass) 
                                                            @if ($schoolClass->id == $item->id)

                                                            selected
                                                            @endif
                                                        @endisset>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Sections</label>
                                            <select name="sections[]" id="section" class="form-control" multiple>
                                                <option value="">Select Section</option>
                                                @isset($schoolClass)
                                                    @foreach ($schoolClass->sections as $s)
                                                        <option value="{{ $s->id }}"
                                                            @if ($section->id == $s->id) selected @endif>
                                                            {{ $s->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="feeItems"> Fee categories</label>
                                            @foreach ($feeItems->chunk(2) as $chunk)
                                                <div class="row">
                                                    @foreach ($chunk as $item)
                                                        <div class="col-md-6">
                                                            <div class="checkbox checkbox-replace">
                                                                <input type="checkbox" name="feeItems[]" class="mt-1"
                                                                    id="subject-{{ $item->id }}" value="{{ $item->id }}"
                                                                    @isset($section)
@if ($section->fee_items()->wherePivot('school_class_id', $schoolClass->id)->get()->pluck('id')->contains($item->id)) checked @endif
                                                                    @endisset>
                                                                <label>{{ $item->name }} - N{{ $item->amount }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-block" type="submit">Save</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-8">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-4">
                                <thead class="">
                                    <tr>
                                        <th>Class Sections</th>
                                        <th>Fees</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($school_classes as $item)
                                        @php
                                            $class_loop = $loop->index;
                                        @endphp
                                        {{-- <tr>
                                            <td class="text-center text-bold" style=""
                                                rowspan="{{ $item->sections->count() }}">
                                                <span class="text bold">
                                                    {{ $item->name }}
                                                </span>
                                            </td>
                                        </tr> --}}
                                        @if ($item->sections->count() > 0)
                                            @foreach ($item->sections as $section)
                                                <tr>
                                                    @php
                                                        $section_loop = $loop->index;
                                                    @endphp
                                                    <td>
                                                        {{ $item->name }} ({{ $section->name }})
                                                    </td>
                                                    @php
                                                        $feeItems = $section
                                                            ->fee_items()
                                                            ->wherePivot('school_id', getSchool()->id)
                                                            ->wherePivot('school_class_id', $item->id)
                                                            ->get();
                                                    @endphp
                                                    @if ($feeItems->count() > 0)
                                                        <td>
                                                            @foreach ($feeItems as $cat)
                                                                {{ $cat->name }} - N{{ $cat->amount }}@if (!$loop->index == count($feeItems))
                                                                    ,
                                                                @endif
                                                            @endforeach

                                                        </td>
                                                    @else
                                                        <td>

                                                        </td>
                                                    @endif
                                                    <td><a href="{{ route('staff.finances.feeSetup', ['school_class' => $item->id, 'section' => $section->id]) }}"
                                                            class="btn btn-secondary btn-sm">Edit</a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Class Sections</th>
                                        <th>Subjects</th>
                                    </tr>
                                </tfoot>
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
