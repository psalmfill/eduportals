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
                Affective Trait
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <h3>Affective Trait Setup</h3>
            <hr>
            <div class="container">
                @if ($affectiveTrait)
                    <form action="{{ route('staff.examination.affectiveTrait.update', $affectiveTrait->id) }}"
                        method="POST" class="form" style="border:1px solid #eee;padding:2% ">
                        @csrf
                        @method('PUT')
                        <fieldset>
                            <legend>Affective Trait Title</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input value="{{ $affectiveTrait->title }}" name="title" type="text"
                                            class="form-control input-lg" placeholder="Title" required>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Subjects</legend>
                            @foreach ($affectiveTrait->subjects->chunk(2) as $chunk)
                                <div class="row">
                                    @foreach ($chunk as $subject)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input name="subjects[{{ $subject->id }}]" value="{{ $subject->title }}"
                                                    type="text" class="form-control  " placeholder="Enter subject"
                                                    required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Affective Trait Grades</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach ($affectiveTrait->grades as $grade)
                                        <div class="row">
                                            <div class="col-md-1">
                                                {{ $loop->index + 1 }}
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="">Grade Name</label>
                                                    <input type="text" value="{{ $grade->name }}"
                                                        name="grades[{{ $grade->id }}][name]" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Grade Remark</label>
                                                <input type="text" value="{{ $grade->remark }}"
                                                    name="grades[{{ $grade->id }}][remark]" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </fieldset>
                        <button class="btn btn-primary btn-lg col-md-6 ">
                            Save
                        </button>
            </div>
            </form>
        @else
            <form action="{{ route('staff.examination.affectiveTrait') }}" method="POST" class="form"
                style="border:1px solid #eee;padding:2% ">
                @csrf
                <fieldset>
                    <legend>Affective Trait Title</legend>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <input name="title" type="text" class="form-control input-lg" placeholder="Title"
                                    required>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend>Subjects</legend>
                    <?php $count = 1; ?>
                    @while ($count <= 5)
                        <div class="row">
                            <div class="col-md-1">
                                {{ $count }}
                            </div>
                            <div class="col-md-5">

                                <div class="form-group">
                                    <input name="subjects[]" type="text" class="form-control " placeholder="Subject name"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="subjects[]" type="text" class="form-control " placeholder="Subject name"
                                        required>
                                </div>
                            </div>
                        </div>
                        <?php $count++; ?>
                    @endwhile

                </fieldset>
                <br>
                <fieldset>
                    <legend>Affective Trait Grades</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <?php $count = 0; ?>
                            @while ($count < 5)
                                <div class="row">
                                    <div class="col-md-1">
                                        {{ $count + 1 }}
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Grade Name</label>
                                            <input type="text" name="grades[{{ $count }}][name]"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Grade Remark</label>
                                        <input type="text" name="grades[{{ $count }}][remark]"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <?php $count++; ?>
                            @endwhile
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg col-md-6">
                        Save
                    </button>
                </div>

            </form>
            @endif
        </div>
    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
