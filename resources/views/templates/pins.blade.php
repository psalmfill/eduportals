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




        table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
        }

        table td,
        table th {
            font-weight: bold !important;
            border-top: 1px solid #333;
            border-right: 1px solid #333;
            margin: 0;
            padding: 5px;
        }

        table tr:last-child td,
        table tr:last-child th {
            border-bottom: 1px solid #333;
        }

        table tr td:first-child,
        table tr th:first-child {

            border-left: 1px solid #333;
        }

        /* .sn {
            float: left;
            margin-left: 4%;
        } */
    </style>
</head>

<body>
    <div class="print-only">

        <table>
            <tr>
                <th>S/N</th>
                <th>PIN</th>
                <th>REF</th>
                <th>DATE</th>
                <th>DURATION</th>
            </tr>
            @foreach ($collection as $pin)
                <tr>
                    <td>{{ $pin->serial_number }}</td>
                    <td>{{ $pin->code }}</td>
                    <td>{{ $pin->ref_code }}</td>
                    <td>{{ $pin->created_at }}</td>
                    <td>{{ $pin->duration }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
