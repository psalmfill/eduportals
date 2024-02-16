<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fee Receipt</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}"> --}}
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        #scale {
            width: 100%;
            border: 1px solid #333;
        }

        #scale tr td {
            border: 0;
        }

        #result {
            width: 1000px !important;
            border: 1px solid #333;
            color: #333;
            /* font-weight: bold !important; */
            margin: 3% auto;
            padding: 10px;
            width: 100%;
            font-size: 9pt;
            text-transform: capitalize;
            /* white-space: nowrap; */
            /* background: #fffaf0; */
            min-height: 842px;
            text-transform: uppercase;
        }

        #result table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
        }

        #result td:first-child {
            border-left: 1px solid #333;
        }

        /* #result tr:first-child{
                border-left: 1px solid #333;
            } */
        #result td,
        #result th {
            font-weight: bold !important;
            border-top: 1px solid #333;
            border-right: 1px solid #333;
            margin: 0;
            padding: 5px;
        }

        #result table tr:last-child td, #result table tr:last-child th{
            border-bottom: 1px solid #333;
            border-bottom: 1px solid #333;

        }

        #result table tr td:first-child,#result table tr th:first-child {

            border-left: 1px solid #333;
        }

        #head {
            width: 100%;
            height: 100px;
            /* border: 1px solid #000; */
        }

        #comments-table {
            width: 100%;
        }

        #comments-table td {
            padding: 10px;
        }

        #comments-table tr td:first-child {
            width: 400px;
        }

        #foot-logo {
            border: 0;
        }

        .col-8 {
            float: left;
            width: 69%;
        }

        .col-4 {
            width: 30%;
            float: right;
        }

        .text-center {
            text-align: center;
        }

        .row::after {
            content: '';
            display: block;
            clear: both;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>

<body oncopy="return false" oncut="return false" onpaste="return false">
    <div id="result">

        <table id="head">
            <tr>
                <th style="width:20%"><img width="140" height="130" class="img-responsive"
                        src="{{ asset(\Storage::url(getSchool()->logo)) }}" alt="logo"></th>
                <th style="width:60%">
                    <div style="">
                        <h1>{{ getSchool()->name }}</h1>
                        <address>{{ getSchool()->address }}, {{ getSchool()->city }}</address>
                        <p>{{ getSchool()->country }}</p>
                    </div>
                    <h1 style="margin-top: 5%">School Fee Receipt</h1>

                </th>
                <th style="width:20%"><img width="130" height="130" class="img-100"
                        src="{{ asset(\Storage::url($fee->student->image)) }}" alt="student"></th>
            </tr>
        </table>
        <br>
        <h3>STUDENT INFORMATION</h3>
        <table style="width:100%">
            <tr>
                <td class="text-bold">Student Name</td>
                <td colspan="5" style="text-align:left">{{ $fee->student->full_name }}</td>
                <td>Class</td>
                <td>{{ $fee->student->school_class->name }} - {{ $fee->student->section->name }}</td>
            </tr>
            <tr>
                <td>Admission Number</td>
                <td>{{ $fee->student->reg_no }}</td>
                <td>Sex</td>
                <td>{{ $fee->student->gender }}</td>
                <td>Session</td>
                <td>{{ $fee->session->name }}</td>
                <td>Term</td>
                <td>{{ $fee->term->name }}</td>
            </tr>


        </table>
        <br>
        <h3 class="text-uppercase">FEE PAYMENT INFORMATION</h3>
        <table id="comments-table" style="margin:2px;width:99.5%">
            @foreach ($fee->transactions as $item)
                <tr>
                    <td>{{ $item->reference }}</td>
                    <td>Date</td>
                    <td>{{$item->created_at->format('d, F Y')}}</td>
                    </td>
                    <td ></td>
                    <td></td>
                </tr>
                <tr>
                    <td >Items</td>
                    <td colspan="4"></td>
                </tr>
                {{-- {{dd($item->items)}} --}}
                @forEach ($item->items as $fee_payment_item)
                {{-- {{dd($fee_payment_item)}} --}}
                    <tr>
                        <td></td>
                        <td>{{$fee_payment_item->fee_item->name}}</td>
                        <td  style="text-align:right" colspan="2">N{{$fee_payment_item->amount}}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach

            <tr>
                <td></td>
                <td>TOTAL FEE</td>
                <td style="text-align:right" colspan="2">N{{ $fee->amount }}</td>
                {{-- <td>{{ $fee->full_payment ? 'FULL PAYMENT' : 'PART PAYMENT' }}</td> --}}
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>PAYMENT Status</td>
                <td style="text-align:right" colspan="2">{{ $fee->full_payment ? 'FULL PAYMENT' : 'PART PAYMENT' }}</td>
                <td></td>
            </tr>
        </table>
        <br>
        <table id="foot-logo" style="width:100%; margin:2px">
            <tr style="border:0px">
                <td style="border:0;"><img height="50" class="img-responsive"
                        src="{{ $generalSettings->coat_of_arm ? asset(\Storage::url($generalSettings->coat_of_arm)) : '' }}"
                        alt="coat of arm"></td>
                <td style="border:0;width:100%"></td>
                <td style="border:0;"><img height="50" class="img-responsive"
                        src="{{ $generalSettings->school_stamp ? asset(\Storage::url($generalSettings->school_stamp)) : '' }}"
                        alt="stamp"></td>
            </tr>
        </table>
    </div>
</body>

</html>
