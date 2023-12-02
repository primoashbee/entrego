<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;

        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }


    </style>
</head>
<style>

</style>

<body>
    <div class="container-fluid">
        <img src="{{ asset('img/logo-ct.png') }}" class="center" width="150px">

        <h1 class="text-center"> Job Applications Reports </h1>


        <div class="row">
            @if ($parameters->has('start_date'))
                <div class="col-2">
                    <p> <b>From</b>: {{ \Carbon\Carbon::parse($parameters->start_date)->format('F d, Y') }} </p>
                </div>
                <div class="col-2">
                    <p> <b>To</b>: {{ \Carbon\Carbon::parse($parameters->end_date)->format('F d, Y') }} </p>
                </div>
            @else
                <div class="col-2">
                    <p> <b>From</b>: ALL </p>
                </div>
                <div class="col-2">
                    <p> <b>To</b>: ALL </p>
                </div>
            @endif



        </div>

        <div class="row">
            <div class="col-3">
                <p style="text-align: left"> <b>Printed By</b> {{ auth()->user()->full_name }}</p>
            </div>

            <div class="col-6"></div>
            <div class="col-3 ">
                <p style="text-align: right"> <b>Date Printed</b> {{ now()->toDateTimeString() }}</p>
            </div>
        </div>





        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Job</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Requested</th>

                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Deployed</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Fulfillment Rate</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">AVG Time to Hire</th>
                  </tr>
            </thead>
            <tbody>
                @foreach($list as $item)
                <tr>
                    <td class="">
                        {{$item->job_title}}
                    </td>
                    <td class="align-middle text-center">
                        {{$item->requested}}
                    </td>
                    <td class="align-middle text-center">
                        {{$item->deployed}}
                    </td>
                    <td class="align-middle text-center">
                        {{$item->fulfillment_rate}}
                    </td>
                    <td class="align-middle text-center">
                        @if($item->avg_tth)
                            {{$item->avg_tth}} days
                        @else
                         - 
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td style="text-align: right">Total:</td>
                    <td style="text-align: left">{{ count($list) }}</td>
                </tr>
            </tfoot>

        </table>


    </div>
    <footer>
        Copyright &copy; <?php echo date('Y'); ?>
    </footer>
</body>

</html>