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
                Exams Setup
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Exams Setup</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">Setup Exam</h4>
                            <hr>
                            @isset($exam)

                                <form action="{{ route('exams-setup.update', $exam->id) }}" method="POST" id="exams-setup">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="control-label">Select Term</label>
                                        @if (!$terms->count())
                                            <div class="alert alert-danger text-center">
                                                You need to create terms to be able to setup exam. <br> <a class="btn btn-info"
                                                    href="{{ route('terms.index') }}">Create Terms</a>
                                            </div>
                                        @endif

                                        <div class="">
                                            @foreach ($terms as $item)
                                                @if ($item->exams->contains($exam))
                                                    <div class="checkbox checkbox-replace">
                                                        <input type="checkbox" name="terms[]" id="section-{{ $item->id }}"
                                                            value="{{ $item->id }}"
                                                            @if ($item->exams->contains($exam)) checked @endif>
                                                        <label>{{ $item->name }}</label>
                                                    </div>
                                                    <br>
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_mark">Total Mark</label>
                                        <input type="number" name="total_mark" id="total-mark" class="form-control"
                                            value="{{ $exam->total_mark }}" required>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-6 container">
                                            <h4>Mark Distribution</h4>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <a onclick="addExamTypeRow()" class="btn btn-primary pull-right btn-sm"><i
                                                    class="entypo-plus"></i></a>

                                        </div>
                                    </div>
                                    <div id="exam-types">
                                        @foreach ($exam->exam_types as $exam_type)
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="name"> Name</label>
                                                        <input name="exam_types[{{ $exam_type->id }}][name]" type="text"
                                                            class="form-control" value="{{ $exam_type->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="mark"> Mark</label>
                                                        <input name="exam_types[{{ $exam_type->id }}][mark]" type="number"
                                                            class="form-control mark" value="{{ $exam_type->mark }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group pt-3"><br>
                                                        <button class="del btn btn-danger btn-sm p-1"><i
                                                                class="entypo-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" id="save" type="submit">Save</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('exams-setup.store') }}" method="POST" id="exams-setup">
                                    @csrf

                                    <div class="form-group">
                                        <label class="control-label">Select Term</label>
                                        @if (!$terms->count())
                                            <div class="alert alert-danger text-center">
                                                You need to create terms to be able to setup exam. <br> <a class="btn btn-info"
                                                    href="{{ route('terms.index') }}">Create Terms</a>
                                            </div>
                                        @endif

                                        <div class="">
                                            @foreach ($terms as $item)
                                                <div class="checkbox checkbox-replace">
                                                    <input type="checkbox" class="mt-1" name="terms[]"
                                                        id="section-{{ $item->id }}" value="{{ $item->id }}">
                                                    <label>{{ $item->name }}</label>
                                                </div>
                                                <br>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_mark">Total Mark</label>
                                        <input type="number" name="total_mark" id="total-mark" class="form-control" required>
                                    </div>
                                    <br>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <h4>Mark Distribution</h4>
                                        </div>
                                        <div class="col-6 justify-content-end">
                                            <a onclick="addExamTypeRow()" class="btn btn-primary btn-sm"><i
                                                    class="entypo-plus"></i></a>

                                        </div>
                                        <br>
                                    </div>
                                    <div id="exam-types">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="name"> Name</label>
                                                    <input name="exam_types[0][name]" type="text" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="mark"> Mark</label>
                                                    <input name="exam_types[0][mark]" type="number"
                                                        class="form-control mark" required>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group pt-3"><br>
                                                    <button class="del btn btn-danger"><i class="entypo-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" id="save" type="submit">Save</button>
                                    </div>
                                </form>
                                @endif

                            </div>
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
                                        <th>Name</th>
                                        <th>Mark Distribution</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($item->exam_types as $type)
                                                        <li>{{ $type->name }} = {{ $type->mark }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <form action="{{ route('exams-setup.destroy', $item->id) }}" method="post"
                                                    class="form-inline d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm icon-left">
                                                        <i class="entypo-trash"></i>
                                                        Delete
                                                    </button>

                                                    <a href="{{ route('exams-setup.edit', $item->id) }}"
                                                        class="btn btn-primary btn-sm icon-left">
                                                        <i class="entypo-trash"></i>
                                                        Edit
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mark Distribution</th>
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
                $('#exam-types').append(` <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="name"> Name</label>
                        <input name="exam_types[${count}][name]" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="mark"> Mark</label>
                        <input name="exam_types[${count}][mark]" type="number" class="form-control mark" required>
                    </div>
                </div>
                 <div class="col-md-1">
                    <div class="form-group mt-3"> <br>
                            <button class="del btn btn-danger p-1"><i class="entypo-trash"></i></button>
                    </div>
                </div>
            </div>`)
            }
            $('#exams-setup').submit(function(e) {
                let sum = 0;
                const total = $('#total-mark').val();
                $('.mark').each(function() {
                    console.log($(this).val())
                    sum += ($(this).val() * 1);
                })
                console.log(sum)
                if (sum != total) {
                    alert('Total mark distribution must be equal to the total mark');
                    e.preventDefault();
                    return;
                }
            })

            $(document).on('click', '.del', function(e) {

                e.preventDefault();
                $(this).parent().parent().parent().remove();
            })
        </script>
    @endsection
