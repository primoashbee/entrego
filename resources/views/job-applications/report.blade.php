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


    </style>
</head>
<style>

</style>

<body>
    <div class="container-fluid">
        <img src="{{ asset('img/logo-ct.png') }}" class="center" width="150px">

        <h1 class="text-center"> Job Applications Reports </h1>

        <div class="row">
            @if (request()->has('start_date'))
                <div class="col-2">
                    <p> <b>From</b>: {{ \Carbon\Carbon::parse(request()->start_date)->format('F d, Y') }} </p>
                </div>
                <div class="col-2">
                    <p> <b>To</b>: {{ \Carbon\Carbon::parse(request()->end_date)->format('F d, Y') }} </p>
                </div>
            @else
                <div class="col-2">
                    <p> <b>From</b>: ALL </p>
                </div>
                <div class="col-2">
                    <p> <b>To</b>: ALL </p>
                </div>
            @endif


            @if (request()->has('status'))
                <div class="col-4">
                    <p style="text-align: right"> <b>Status</b>: {{ request()->status }}</p>
                </div>
            @else
                <div class="col-4">
                    <p style="text-align: right"> <b>Status</b>: ALL </p>
                </div>
            @endif


            @if (request()->has('department'))
                <div class="col-4">
                    <p style="text-align: right"> <b>Department</b>: {{ request()->department }}</p>
                </div>
            @else
                <div class="col-4">
                    <p style="text-align: right"> <b>Department</b>: ALL</p>
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
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Job Applied</th>
                    <th scope="col">Status</th>
                    <th scope="col">Applied</th>
                    <th scope="col">Interview Date</th>
                    <th scope="col">Offer Sent</th>
                    <th scope="col">Offer Accepted</th>
                    <th scope="col">Deployed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $key => $applicant)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td> {{ $applicant->user->full_name }}</td>
                        <td> {{ $applicant->user->email }}</td>
                        <td> {{ $applicant->job->job_title }}</td>
                        <td> {{ $applicant->status_name }}</td>
                        <td> {{ $applicant->created_at }}</td>
                        <td> {{ $applicant->interview_date }}</td>
                        <td> {{ $applicant->job_offered_at }}</td>
                        <td> {{ $applicant->job_offer_accepted_at }}</td>
                        <td> {{ $applicant->deployed_at }}</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8"></td>
                    <td style="text-align: right">Total:</td>
                    <td style="text-align: left">{{ $applicants->count() }}</td>
                </tr>
            </tfoot>

        </table>


    </div>
    <footer>
        Copyright &copy; <?php echo date('Y'); ?>
    </footer>
</body>

</html>
