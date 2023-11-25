@extends('layouts.vendor')

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="#">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <h3>Academics</h3>
    <div class="row">
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Staff</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $staffCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Students</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-info d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $studentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Subjects</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-success d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $subjectCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Classes</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $classCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sections</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $sectionCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <h3 class="mt-3">Finances</h3>
    <div class="row">
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Debit Transactions</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-secondary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">N{{ number_format($debitTransaction, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Credit Transactions</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-secondary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ number_format($creditTransaction, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Expenditures</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-secondary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $totalExpenditure }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-4 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Fees</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-warning d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $totalFee }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
