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
                Comment result Setup
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Comment Result Setup</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">Group</h4>
                            <hr>
                            @isset($group)
                                <form action="{{ route('staff.comment_result.setup_update', $group->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="title">Subject title</label>
                                        <input type="text" value="{{ $group->title }}" name="title" class="form-control">
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 container">
                                            <h4>Topics</h4>
                                        </div>
                                        <div class="col-6">
                                            <a onclick="addRow()" class="btn btn-primary pull-right"><i
                                                    class="entypo-plus"></i></a>
                                        </div>
                                    </div>
                                    <div id="topics">
                                        @foreach ($group->topics as $item)
                                            <div class="form-group">
                                                <input type="text" name="topics[{{ $item->id }}]"
                                                    value="{{ $item->title }}" placeholder="Enter topic name"
                                                    class="form-control topic">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('staff.comment_result.setup_post') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Subject title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-6 container">
                                            <h4>Topics</h4>
                                        </div>
                                        <div class="col-6">
                                            <a onclick="addRow()" class="btn btn-primary pull-right"><i
                                                    class="entypo-plus"></i></a>

                                        </div>
                                    </div>
                                    <div id="topics">
                                        <br>
                                        <div class="form-group">
                                            <input type="text" name="topics[]" placeholder="Enter topic name"
                                                class="form-control topic">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                                    </div>
                                </form>
                            @endisset
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
                                    <th>Group</th>
                                    <th>Topics</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($item->topics as $type)
                                                    <li>{{ $type->title }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>
                                            <form action="{{ route('staff.comment_result.setup_destroy', $item->id) }}"
                                                method="post" class="form-inline">
                                                @csrf
                                                @method('delete')
                                                <div class="">
                                                    <a href="{{ route('staff.comment_result.setup_edit', $item->id) }}"
                                                        class="btn btn-info btn-sm icon-left"><i class="entypo-pencil"></i>
                                                        Edit</a>
                                                    <button class="btn btn-danger btn-sm icon-left">
                                                        <i class="entypo-trash"></i>
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Group</th>
                                    <th>Topics</th>
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
        <script>
            function addRow(e) {
                // e.preventDefault();
                let count = $('.topic').length;
                if (count > 5) {
                    alert('maximum topic allowed has been reached');
                    return;
                }
                console.log(count);
                $('#topics').append(` <div class="form-group">
                   <input type="text" name="topics[]" placeholder="Enter topic name" class="form-control topic">
               </div>`)
            }
            $('#exams-setup').on('submit', function(e) {
                e.preventDefault();
                console.log(e);
            })
        </script>
    @endsection
