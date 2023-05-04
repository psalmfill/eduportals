<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 1px;
            padding: 1px;
        }

        .print-only {
            page-break-after: auto;
            width: 100%;
            padding: 1% 0;
        }

        .row::after {
            content: ' ';
            display: block;
            clear: both;
        }

        .pin {
            background: #01256d;
            width: 48%;
            height: 260px;
            color: #fff;
            text-align: center;
            /* border: 2px solid #000; */
            float: left;
            padding: 0.9%;

        }

        .pin-text {
            margin: 0 auto;
        }

        .pin-card {
            background: #fff;
            font-size: 1.2em;
            width: 70%;
            margin: 20px auto;
            text-align: center;
            padding: 2px;
            color: #000000;
        }

        .school span {
            font-size: 1em;
        }

        .url {
            color: #ffffff;
            margin: 2px;
        }

        .date {
            float: right;
            font-size: 0.8em;
            margin-right: 2%;
        }

        .date::after {
            content: '';
            display: block;
            clear: both;
        }

        .info {
            text-align: center;
            background: rgb(54, 16, 222);
            font-size: 0.8em;
            padding: 1px;
            padding-bottom: 5px;
            margin-top: 5px;

        }

        /* .sn {
            float: left;
            margin-left: 4%;
        } */
    </style>
</head>

<body>
    <div class="print-only">
        @foreach ($collection->chunk(2) as $chunk)
            <div class="row">
                @foreach ($chunk as $pin)
                    <div class="pin">
                        <div class="school">
                            {{-- <img width="50" height="50"
                                src="{{ $pin->school->logo ? public_path(\Storage::url($pin->school->logo)) : '' }}"
                                alt="logo" class="logo" style="display:inline"> --}}
                            <span>{{ $pin->school->name }}</span>
                        </div>
                        <div> Result Checking Pin</div>
                        <div class="url">visit {{ $pin->school->code }}.eduportals.com/login to login</div>
                        {{-- <span class="pin-text">PIN</span> --}}
                        <div class="pin-card">{{ $pin->code }}</div>
                        <hr>
                        <div class="sn">S/N: <span> {{ $pin->serial_number }}</span></div>
                        <div class="rf">REF: <span>{{ $pin->ref_code }}</span></div>
                        <hr>
                        <div class="date">DATE: <span>{{ $pin->created_at }}</span></div><br>
                        <div class="info">Pin expires {{ $pin->duration }} days from first usage. For enquiry and
                            complaints regarding the pin usage, please contact the school administrator.</div>

                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>

</html>
