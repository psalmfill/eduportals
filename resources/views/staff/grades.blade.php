@extends('layouts.dashboard')


@section('page_styles')
    
	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}">
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
<h3>All Grade</h3>
<div class="container-fluid p-3">
<div class="row">
    <div class="col-md-4">
        <div class="well">
        <h4 class="margin">{{isset($grade)?'Edit':'Create'}} Grade</h4>
        <hr>
        @isset($grade)
        <form action="{{route('grades.update',$grade->id)}}" method="POST">
                @csrf
                @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>

            <input type="text" name="name" class="form-control" value="{{$grade->name}}">
            </div>
            <div class="form-group">
                <label for="name">Minimum Score</label>

                <input type="number" name="minimum_score" class="form-control"  value="{{$grade->minimum_score}}">
            </div>
            <div class="form-group">
                <label for="name">Maximum Score</label>

                <input type="number" name="maximum_score" class="form-control"  value="{{$grade->maximum_score}}">
            </div>
            <div class="form-group">
                <label for="name">Remark</label>

                <input type="text" name="remark" class="form-control"  value="{{$grade->remark}}">
            </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                    </div>
                </form>
        @else
         <form action="{{route('grades.store')}}" method="POST">
        @csrf
            <div class="form-group">
                <label for="name">Name</label>

                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Minimum Score</label>

                <input type="number" name="minimum_score" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Maximum Score</label>

                <input type="number" name="maximum_score" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Remark</label>

                <input type="text" name="remark" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create</button>
            </div>
        </form>
        @endisset
       
        </div>
    </div>
    <div class="col-md-6">

        <table class="table table-bordered table-striped " >
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Minimum Score</th>
                    <th>Maximum Score</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $item)
                    <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->minimum_score}}</td>
                    <td>{{$item->maximum_score}}</td>
                    <td>{{$item->remark}}</td>
                    <td>
                        <a href="{{route('grades.edit',$item->id)}}" class="btn btn-primary btn-sm btn-icon icon-left  pull-left">
                            <i class="entypo-pencil"></i>
                            Edit
                        </a>
                        <form action="{{route('grades.destroy',$item->id)}}" method="post" class="form-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm btn-icon icon-left">
                                    <i class="entypo-trash"></i>
                                    Delete
                            </button>
                        </form>
                    </td>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Minimum Score</th>
                    <th>Maximum Score</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('page_scripts')
    
	
@endsection