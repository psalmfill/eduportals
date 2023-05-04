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
                Question
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>CBT Management</h1>
            <h3>Question Setup for {{ $subject->name }}</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4 pr-4">
                        <h4 class="margin">Questions</h4>
                        <hr>
                        @isset($question)
                            <form action="{{ route('staff.cbt.subjects.questions.update', [$subject->id, $question->id]) }}"
                                method="POST" id="exams-setup">
                                @method('put')
                                @csrf
                                <div class="form-group">
                                    <label for="total_mark">Question</label>
                                    <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ old('content') ?? $question->content }}</textarea>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between mb-3">
                                    <h4>Options</h4>
                                    <a onclick="addExamTypeRow()" class="btn btn-primary pull-right p-1"><i
                                            class="entypo-plus"></i></a>
                                </div>

                                <div class="form-group">
                                    <label for="mark">Mark</label>
                                    <input type="number" class="form-control" value="{{ $question->mark }}" name="mark">
                                </div>
                                <div id="exam-types">
                                    @foreach ($question->options as $opt)
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="d-flex justify-content-around">
                                                    <div class="checkbox checkbox-replace">
                                                        <label>Answer</label><br>
                                                        <input type="checkbox" name="options[{{ $opt->id }}][is_correct]"
                                                            class="mt-3" {{ $opt->is_correct ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"> Option</label>
                                                        <input name="options[{{ $opt->id }}][content]" type="text"
                                                            class="form-control" value="{{ $opt->content }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group pt-3"><br>
                                                    <a href="{{ route('staff.cbt.question.option.delete', $opt->id) }}"
                                                        class="btn btn-danger p-1"><i class="entypo-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @error('options')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" id="save" type="submit">Save</button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('staff.cbt.subjects.questions.store', $subject->id) }}" method="POST"
                                id="exams-setup">
                                @csrf
                                <div class="form-group">
                                    <label for="total_mark">Question</label>

                                    <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between mb-3">
                                    <h4>Options</h4>
                                    <a onclick="addExamTypeRow()" class="btn btn-primary pull-right p-1"><i
                                            class="entypo-plus"></i></a>
                                </div>
                                <div class="form-group">
                                    <label for="mark">Mark</label>
                                    <input type="number" class="form-control" value="1" name="mark">
                                </div>
                                <div id="exam-types">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="d-flex justify-content-around">
                                                <div class="checkbox checkbox-replace">
                                                    <label>Answer</label><br>
                                                    <input type="checkbox" name="options[0][is_correct]" class="mt-3">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name"> Option</label>
                                                    <input name="options[0][content]" type="text" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group pt-3"><br>
                                                <button class="del btn btn-danger p-1"><i class="entypo-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('options')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" id="save" type="submit">Save</button>
                                </div>
                            </form>
                            @endif

                        </div>
                        <div class="col-md-8">
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    var $table4 = jQuery("#table-4");

                                    $table4.DataTable();
                                });
                            </script>

                            <table class="table  table-bordered datatable dataTable no-footer" id="table-4">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Answer</th>
                                        <th>Option Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $item)
                                        <tr>
                                            <td>{{ $item->content }}</td>
                                            <td>
                                                @foreach ($item->options as $opt)
                                                    {{ $opt->content }}{{ $loop->index != $item->options->count() - 1 ? ',' : '' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->options->where('is_correct') as $opt)
                                                    {{ $opt->content }}{{ $loop->index != $item->options->where('is_correct')->count() - 1 ? ',' : '' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $item->options->count() }}
                                            </td>
                                            <td>
                                                <form action="{{ route('exams-setup.destroy', $item->id) }}" method="post"
                                                    class="form-inline d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="btn-group">
                                                        <button type="submit" class="btn btn-danger btn-sm icon-left">
                                                            <i class="entypo-trash"></i>
                                                            Delete
                                                        </button>

                                                        <a href="{{ route('staff.cbt.subjects.questions.edit', [$subject->id, $item->id]) }}"
                                                            class="btn btn-primary btn-sm icon-left">
                                                            <i class="entypo-pencil"></i>
                                                            Edit
                                                        </a>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Option Count</th>
                                        <th>Action</th>
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
            function addExamTypeRow(e) {
                // e.preventDefault();
                let count =
                    @isset($question)

                        {{ $question->options->last()->id + 1 }}
                    @else
                        $('#exam-types').children().length
                    @endisset
                $('#exam-types').append(`  <div class="row">
                                            <div class="col-md-11">
                                                <div class="d-flex justify-content-around">
                                                    <div class="checkbox checkbox-replace">
                                                        <label>Answer</label><br>
                                                        <input type="checkbox" name="options[${count}][is_correct]" class="mt-3">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"> Option</label>
                                                        <input name="options[${count}][content]" type="text" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group pt-3"><br>
                                                    <button class="del btn btn-danger p-1"><i class="entypo-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>`)
            }


            $(document).on('click', '.del', function(e) {

                e.preventDefault();
                $(this).parent().parent().parent().remove();
            })
        </script>
    @endsection
