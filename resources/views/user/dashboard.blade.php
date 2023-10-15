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
                    <div class="col-lg-3 col-sm-5">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person_add</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Manpower Requests</p>
                                    <h4 class="mb-0">{{ $manpower->active . '/' . $manpower->total }}</h4>
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
                    <div class="col-lg-3 col-sm-5">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">group</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Applicants</p>
                                    <h4 class="mb-0">{{ $applicant->active . '/' . $applicant->total }}</h4>
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
                    <div class="col-lg-3 col-sm-5">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">sync</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Processing</p>
                                    <h4 class="mb-0">{{ $processing->active . '/' . $processing->total }}</h4>
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
                    <div class="col-lg-3 col-sm-5">
                        <div class="card  mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">work</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Deployed</p>
                                    <h4 class="mb-0">{{ $deployed->active . '/' . $deployed->total }}</h4>
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
                    <div class="card-header pb-0">
                        <h6>Manpower overview</h6>
                        <p class="text-sm">
                            <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p>
                    </div>
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
