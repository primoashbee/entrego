@extends('layouts.user')
@section('title', 'My Title')
@section('styles')
    <style>
        .title {
            color: rgb(252, 103, 49);
            font-weight: 600;
            margin-bottom: 2vh;
            padding: 0 8%;
            font-size: initial
        }

        #details {
            font-weight: 400
        }

        .info {
            padding: 5% 8%
        }

        .info .col-5 {
            padding: 0
        }

        #heading {
            color: grey;
            line-height: 6vh
        }

        #progressbar {
            margin-bottom: 3vh;
            overflow: hidden;
            color: rgb(252, 103, 49);
            padding-left: 0px;
            margin-top: 3vh;

            margin: auto;
            width: 80%;
            padding: 10px;
        }

        #progressbar li {
            list-style-type: none;
            /* font-size: x-small; */
            width: 15%;
            float: left;
            position: relative;
            font-weight: 400;
            color: rgb(160, 159, 159)
        }

        #progressbar #step1:before {
            content: "";
            color: rgb(252, 103, 49);
            width: 5px;
            height: 5px;
            margin-left: 0px !important
        }

        #progressbar #step2:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-left: 32%;
            text-align: center;
        }

        #progressbar #step3:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32%
        }

        #progressbar #step4:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 35%
        }

        #progressbar #step5:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32%
        }

        #progressbar #step6:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32%
        }

        #progressbar #step4:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 0px !important
        }

        #progressbar li:before {
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: #ddd;
            border-radius: 50%;
            margin: auto;
            z-index: -1;
            margin-bottom: 1vh
        }

        #progressbar li:after {
            content: '';
            height: 2px;
            background: #ddd;
            position: absolute;
            left: 0%;
            right: 0%;
            margin-bottom: 2vh;
            top: 1px;
            z-index: 1
        }

        .progress-track {
            padding: 0;
        }

        #progressbar li:nth-child(2):after {
            margin-right: auto
        }

        #progressbar li:nth-child(1):after {
            margin: auto
        }

        #progressbar li:nth-child(3):after {
            float: left;
            width: 68%
        }

        #progressbar li:nth-child(4):after {
            margin-left: auto;
            width: 132%
        }

        #progressbar li.active {
            color: black
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: rgb(252, 103, 49)
        }
    </style>
@endsection
@section('content')
<?php 
$steps = $application->steps();
$last_activity = $application->lastActivity();
$last_activity_name = $last_activity['status'];
if($application->status === 'CANCELLED'){
    $key = $steps->search(function($item) use ($last_activity_name){
        return $item['key'] == $last_activity_name;
    });
    $cancelled = [
                    'label'=>'Cancelled',
                    'key'=>'CANCELLED',
                    'date'=>$application->cancelled_at,
                    'data'=> [
                        'notes'=> $application->cancelled_notes
                    ],
                    'class'=> 'active text-center',
                    'finished'=>true,
                    'id' => 'step4',
                    'processor'=>$application->cancellor
                ];
    $steps->splice($key, 0, [$cancelled]);
}   
if($application->status === 'REJECTED'){
    $key = $steps->search(function($item) use ($last_activity_name){
        return $item['key'] == $last_activity_name;
    });
    $cancelled = [
                    'label'=>'Rejected',
                    'key'=>'REJECTED',
                    'date'=>$application->rejected_at,
                    'data'=> [
                        'notes'=> $application->rejected_notes
                    ],
                    'class'=> 'active text-center',
                    'finished'=>true,
                    'id' => 'step4',
                    'processor'=>$application->cancellor
                ];
    $steps->splice($key, 0, [$cancelled]);
}   
?>
    <div class="container-fluid py-4" id="div-view">
        @include('components.errors')
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-10 col-sm-2 position-relative z-index-2">
                    <div class="row mt-4">

                        <div class="col-12">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                        <i class="material-icons opacity-10" aria-hidden="true">group</i>
                                    </div>
                                    <h6 class="mt-3 mb-2 ms-3 "> {{ $application->job->job_title }} </h6>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Department: <strong>{{ $application->job->departmentLink->value }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Required Experience:
                                                <strong>{{ $application->job->required_experience_name }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Posted On:
                                                <strong>{{ $application->job->created_at->format('F d, Y') }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Posted On:
                                                <strong>{{ $application->job->created_at->format('F d, Y') }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Applicant Name: <strong><a href="{{route('users.edit',$application->user_id)}}" target="_blank">{{ $application->user->full_name }}</a></strong></p>
                                        </div>
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Email: <strong>{{ $application->user->email }}</strong></p>
                                        </div>
                                        <div class="col-sm-12 col-lg-3">
                                        </div>
                                        @if(auth()->user()->role == 'ADMINISTRATOR')
                                        <div class="col-sm-12 col-lg-3">
                                            <p> Requested By: <strong>{{ $application->job->requestor->full_name }}</strong></p>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    {{-- <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">group</i>
                                </div> --}}
                                    {{-- <h6 class="mt-3 mb-2 ms-3 "> {{$application->job->job_title}} </h6> --}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mx-auto">

                                            <div class="tracking">
                                                <div class="text-center title"> Job Tracking</div>
                                            </div>
                                            <div class="progress-track">

                                                <ul id="progressbar">
                                                    @foreach ($steps as $key => $step)
                                                    
                                                        @if ($key == 0)
                                                            @if($step['key'] == 'CANCELLED' || $step['key'] == 'REJECTED')
                                                                <li class="step0 active" id="step4">{{ $step['label'] }}</li>
                                                            @else
                                                                <li class="step0 active" id="step1">{{ $step['label'] }}</li>
                                                            @endif
                                                        @elseif($key == count($application->steps()) - 1)
                                                            <li class="step0  {{ $step['class'] }}" id="step4" style="text-align: right !important">
                                                                {{ $step['label'] }}</li>
                                                        @else
                                                            @if($step['key'] == 'CANCELLED'  || $step['key'] == 'REJECTED')
                                                                <li class="step0 {{ $step['class'] }}" id="step4">{{ $step['label'] }}</li>
                                                            @else
                                                                <li class="step0 {{ $step['class'] }}" id="step2">{{ $step['label'] }}</li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    {{-- <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">group</i>
                                </div> --}}
                                    {{-- <h6 class="mt-3 mb-2 ms-3 "> {{$application->job->job_title}} </h6> --}}
                                </div>
                                <div class="card-body">
                                    @foreach (collect($steps)->sortByDesc('date') as $step)
                                        @if ($step['finished'])
                                            <figure class="px5">
                                                <blockquote class="blockquote">
                                                    <h4 class="px-2"> {{ $step['label'] }} <h4>
                                                    <p class="ps-2">{{ $step['data']['notes'] }}.</p>
                                                </blockquote>
                                                <figcaption class="blockquote-footer ps-3">
                                                    Processed By: <cite title="Source Title"><strong>[{{$step['processor']->role_name}}] - {{$step['processor']?->full_name}} </strong> on <strong>{{ \Carbon\Carbon::parse($step['date'])->format('F d ,Y g:iA') }}</strong></cite>
                                                </figcaption>
                                            </figure>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-2 col-sm-12 mt-4 mr-2">
                    <div class="card">
                        <div class="card-body">
                            <p> <strong> Other Applications: <span
                                        class="badge bg-gradient-success">{{ $other_jobs->count() }}</span> </strong> </p>

                            <ul class="list-group list-group-flush">
                                @foreach ($other_jobs as $application)
                                    <a href="{{ route('user-job.show', $application->id) }}">
                                        <li class="list-group-item">{{ $application->job->job_title }} </li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
