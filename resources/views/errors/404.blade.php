@extends('layouts.frontend')
@section('page_styles')
    <style>
    .page-error-404 {
        height: 60vh !important;
        text-align: center;
        /* display: relative; */
    }
    .error-text {
        position: absolute;
        top: 40%;
        left: 40%;
    }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="page-error-404 text-center m-5">
		
        
        <div class="error-text">
        <hr>	
            <div class="error-symbol">
                <i class="entypo-attention"></i>
            </div>
                <h1>404</h1>
                <p>The Page you are trying to access was not found!</p>
        <a href="{{url()->previous()}}">Back</a>
        <hr />
        </div>
        
        
        {{-- <div class="error-text">
            
            Search Pages:
            
            <br />
            <br />
            
            <div class="input-group minimal">
                <div class="input-group-addon">
                    <i class="entypo-search"></i>
                </div>
                
                <input type="text" class="form-control" placeholder="Search anything..." />
            </div>
            
        </div>
         --}}
    </div>
    <br>
</div>
@endsection