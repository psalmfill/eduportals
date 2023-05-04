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
            <h3>All Classes</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <div class="col-md-4">
                            <div class="well">
                                <h4 class="margin">{{ isset($school_class) ? 'Edit' : 'Create' }} Class</h4>
                                <hr>
                                @isset($school_class)
                                    <form action="{{ route('classes.update', $school_class->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" value="{{ $school_class->name }}"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Sections</label>

                                            <div class="">

                                                <div class="row">
                                                    @foreach ($sections->chunk(3) as $items)
                                                        @foreach ($items as $item)
                                                            <div class="col-md-4">
                                                                <div class="checkbox checkbox-replace">
                                                                    <input type="checkbox" name="sections[]" class="mt-1"
                                                                        id="section-{{ $item->id }}"
                                                                        value="{{ $item->id }}"
                                                                        {{ $school_class->sections->contains($item) ? 'checked' : '' }}>
                                                                    <label>{{ $item->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('classes.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>

                                            <input type="text" name="name" class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Sections</label>
                                            @if (!$sections->count())
                                                <div class="alert alert-danger text-center">
                                                    You need to create sections to be able to create class. <br> <a
                                                        class="btn btn-info" href="{{ route('sections.index') }}">Create
                                                        Sections</a>
                                                </div>
                                            @endif
                                            <div class="row">
                                                @foreach ($sections->chunk(3) as $items)
                                                    @foreach ($items as $item)
                                                        <div class="col-md-4">

                                                            <div class="checkbox checkbox-replace">
                                                                <input type="checkbox" name="sections[]" class="mt-1"
                                                                    id="section-{{ $item->id }}"
                                                                    value="{{ $item->id }}">
                                                                <label>{{ $item->name }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit"
                                                {{ !$sections->count() ? 'disabled' : '' }}>Create</button>
                                        </div>
                                    </form>
                                @endisset

                            </div>
                        </div>
                    @endif
                    <div class="col-md-8">

                        <table class="table table-bordered " id="table-4">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sections</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($school_classes as $item)
                                    <tr>
                                        <td rowspan="{{ $item->sections->count() != 0 ? $item->sections->count() : 1 }}">
                                            {{ $item->name }}</td>

                                        @foreach ($item->sections as $section)
                                            @if (!$loop->index)
                                                <td>

                                                    {{ $section->name }}
                                                </td>
                                                @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                                    <td rowspan="{{ $item->sections->count() }}">

                                                        <form action="{{ route('classes.destroy', $item->id) }}"
                                                            method="post" class="form-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="btn-group">
                                                                <a href="{{ route('classes.edit', $item->id) }}"
                                                                    class="btn btn-info btn-sm icon-left  pull-left">
                                                                    <i class="entypo-pencil"></i>
                                                                    Edit
                                                                </a>
                                                                <button class="btn btn-danger btn-sm icon-left">
                                                                    <i class="entypo-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                @endif
                                    </tr>
                                    @continue
                                @endif
                                <tr>
                                    <td>

                                        {{ $section->name }}
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Sections</th>
                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
    @endsection
