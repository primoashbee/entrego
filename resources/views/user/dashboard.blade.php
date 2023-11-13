@extends('layouts.user')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="card card-plain mb-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <h2 class="font-weight-bolder mb-0">Entrego Dashboard </h2>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person_add</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Manpower Requests</p>
                                    <h4 class="mb-0">{{ $manpower->active . '/' . $manpower->total }}</h4>
                                    <ul class="list-group" style="text-align: left !important; min-height:250px; max-height:250px; overflow-y:scroll">
                                        @foreach($manpower->list as $item)
                                        <li class="list-group-item">                                            
                                            <div class="form-check form-switch  is-filled">
                                                <input class="form-check-input" type="checkbox" manpower-id="1" id="flexSwitchCheckDefault" checked="&quot;&quot;">
                                            </div>
                                            <span style="margin-left: 50px">{{$item->job_title}}</span>  

                                        </li>
                                        @endforeach
                                      </ul>
                                </div>
                            </div>

                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                @if($manpower->variation < 0)
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @else
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">group</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Applicants</p>
                                    <h4 class="mb-0">{{ $applicant->active . '/' . $applicant->total }}</h4>
                                    <ul class="list-group" style="text-align: left !important; min-height:250px; max-height:250px; overflow-y:scroll">
                                        @foreach($applicant->list as $item)
                                        <li class="list-group-item">                                            
                                            <span style="float:left">{{$item->full_name}}</span>  
                                            <span style="float:right; text-align:left"> {{$item->lastUserActivity()}}</span>
                                        </li>
                                        @endforeach
                                      </ul>
                                      
                                </div>
                            </div>

                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                @if($manpower->variation < 0)
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @else
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">sync</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Processing</p>
                                    <h4 class="mb-0">{{ $processing->active . '/' . $processing->total }}</h4>
                                    <ul class="list-group" style="text-align: left !important; min-height:250px; max-height:250px; overflow-y:scroll">
                                        @foreach($processing->list as $item)
                                        <li class="list-group-item">                                            
                                            <span style="float:left"><b>[{{$item->job->job_title}}]</b> {{$item->user->fullname}}</span>  
                                            @if($item->status == 'WAITING_FOR_EXAM_RESULT')
                                            <span style="float:right" class="badge bg-gradient-secondary">{{ $item->status_name }}</span>
                                            @elseif($item->status=='EXAM_PASSED')
                                            <span style="float:right" class="badge bg-gradient-success">{{ $item->status_name }}</span>
                                            @elseif($item->status=='EXAM_FAILED')
                                            <span style="float:right" class="badge bg-gradient-danger">{{ $item->status_name }}</span>
                                            @elseif($item->status=='INTERVIEW_SENT')
                                            <span style="float:right" class="badge bg-gradient-info">{{ $item->status_name }}</span>
                                            @elseif($item->status=='FOR_SENDING_INTERVIEW')
                                            <span style="float:right" class="badge bg-gradient-info">{{ $item->status_name }}</span>
                                            @elseif($item->status=='REJECTED')
                                            <span style="float:right" class="badge bg-gradient-danger">{{ $item->status_name }}</span>
                                            @elseif($item->status=='APPROVED')
                                            <span style="float:right" class="badge bg-gradient-success">{{ $item->status_name }}</span>
                                            @elseif($item->status=='FOR_REQUIREMENTS')
                                            <span style="float:right" class="badge bg-gradient-info">{{ $item->status_name }} {{$item->user->requirement_summary}} </span> <br> 
                                            <a href="{{route('requirements.index',['ids'=>implode(',',$item->user->requirements->pluck('id')->toArray())])}}" style="float:right" class="text-xs font-weight-bold mb-0">Click to View</a>
                                            @elseif($item->status=='JOB_OFFER')
                                            <span style="float:right" class="badge bg-gradient-secondary">{{ $item->status_name }}</span>
                                            @elseif($item->status=='DEPLOYED')
                                            <span style="float:right" class="badge bg-gradient-success">{{ $item->status_name }}</span>
                                            @endif
                                        </li>
                                        @endforeach
                                      </ul>
                                </div>
                            </div>

                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                @if($manpower->variation < 0)
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @else
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">work</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Deployed</p>
                                    <h4 class="mb-0">{{ $deployed->active . '/' . $deployed->total }}</h4>
                                    <ul class="list-group" style="text-align: left !important; min-height:250px; max-height:250px; overflow-y:scroll">
                                        @foreach($deployed->list as $item)
                                        <li class="list-group-item">                                            
                                            <span style="float:left"><b>[{{$item->job->job_title}}]</b> {{$item->user->fullname}}</span>  
                                            <span style="float:right"><b>{{$item->hiringTimeSpan()}}</span>  
                                          
                                        </li>
                                        @endforeach
                                      </ul>
                                </div>
                            </div>

                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                @if($manpower->variation < 0)
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @else
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">{{$manpower->variation}}% </span>than
                                    last month
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-4">

            <div class="col-lg-12">
                <div class="card z-index-2">
                    {{-- <div class="card-header pb-0">
                        <h6>Manpower overview</h6>
                        <p class="text-sm">
                            <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p>
                    </div> --}}
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Job Title</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Applicants</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rejected</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Approved</th>
                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deployed</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($manpower->overview as $overview)
                                <tr>
                                  <td>
                                    <div class="d-flex px-2 py-1">
                                      <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{$overview->job_title}}</h6>
                                       </div>
                                    </div>
                                  </td>

                                  <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"> {{$overview->total}} </span>
                                  </td>

                                  <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"> {{$overview->rejected}} </span>
                                  </td>

                                  <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"> {{$overview->approved}} </span>
                                  </td>

                                  <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"> {{$overview->deployed}} </span>
                                  </td>


                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div id="globe" class="position-absolute end-0 top-10 mt-sm-3 mt-7 me-lg-7">
                    <canvas width="700" height="600"
                        class="w-lg-100 h-lg-100 w-75 h-75 me-lg-0 me-n10 mt-lg-5"></canvas>
                </div>
            </div>
        </div>


        @include('components.footer')

    </div>
@endsection
