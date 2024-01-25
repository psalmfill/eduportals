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
                Staff
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Assign Classes
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <h3>Assign Classes</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">{{ isset($currentStaff) ? 'Edit' : 'Assign' }} Class</h4>
                            <hr>
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
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div>{{ $class->name }}</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="control-label">Sections</label>

                                                        @php
                                                            $classSections = App\Models\Staff::classSections($currentStaff->id, $class->id, getSchool()->id);
                                                        @endphp
                                                        <div class="row">
                                                            @foreach ($class->sections->chunk(2) as $items)
                                                                @foreach ($items as $item)
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox checkbox-replace m-0">
                                                                            <input type="checkbox" class="mt-1"
                                                                                name="sections[{{ $class->id }}][]"
                                                                                id="section-{{ $item->id }}"
                                                                                value="{{ $item->id }}"
                                                                                {{ $classSections->contains($item) ? 'checked' : '' }}>
                                                                            <label class="mr-2">{{ $item->name }}</label>
                                                                        </div>

                                                                    </div>
                                                                @endforeach
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
                                <form action="{{ route('staff.classes.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Select Staff</label>
                                        <select class="form-control" name="staff" id="" required>
                                            <option value="">Select Staff</option>
                                            @foreach ($staff as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        @foreach ($schoolClasses as $class)
                                            <div class="row" >
                                                <div class="col-md-4">
                                                    <div>{{ $class->name }}</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="control-label">Sections</label>

                                                        <div class="row">
                                                            @foreach ($class->sections->chunk(2) as $items)
                                                                @foreach ($items as $item)
                                                                    <div class="col-md-6">
                                                                        <span class="checkbox checkbox-replace m-0">
                                                                            <input type="checkbox" class="mt-1"
                                                                                name="sections[{{ $class->id }}][]"
                                                                                id="section-{{ $item->id }}"
                                                                                value="{{ $item->id }}">
                                                                            <label class="mr-1">{{ $item->name }}</label>
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Assign</button>
                                    </div>
                                </form>
                            @endisset

                        </div>
                    </div>
                    <div class="col-md-8 p-2">
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table4 = jQuery("#table-4");

                                // $table4.DataTable();
                            });
                        </script>

                        <table class="table table-bordered no-footer" id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Classes</th>
                                    <th>Sections</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffWithClasses as $staff)
                                    <tr>
                                        <td rowspan="{{ $staff->school_classes->unique()->count() }}">{{ $staff->name }}
                                        </td>
                                        @foreach ($staff->school_classes->unique() as $class)
                                            @if (!$loop->index)
                                                <td>{{ $class->name }}</td>

                                                <td>

                                                    @foreach ($classSection = App\Models\Staff::classSections($staff->id, $class->id, getSchool()->id) as $item)
                                                        {{ $item->name }}{{ $loop->index == $classSection->count() - 1 ? '' : ',' }}
                                                    @endforeach
                                                </td>
                                                <td rowspan="{{ $staff->school_classes->unique()->count() }}">
                                                    <a href="{{ route('staff.classes.edit', $staff->id) }}"
                                                        class="btn btn-primary btn-sm icon-left  ">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                    </a>
                                                </td>
                                    </tr>
                                @else
                                    <tr>
                                        {{-- <td></td> --}}
                                        <td>{{ $class->name }}</td>
                                        <td>

                                            @foreach ($classSection = App\Models\Staff::classSections($staff->id, $class->id, getSchool()->id) as $item)
                                                {{ $item->name }}{{ $loop->index == $classSection->count() - 1 ? '' : ',' }}
                                            @endforeach
                                        </td>
                                        {{-- <td></td> --}}
                                    </tr>
                                @endif
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Classes</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
    @endsection
