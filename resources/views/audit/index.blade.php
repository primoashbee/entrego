@extends('layouts.user')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 position-relative z-index-2">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 ">
                        <div class="d-flex">
                            <div
                                class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                <i class="material-icons opacity-10" aria-hidden="true">assignment</i>
                            </div>
                                                    
                            <h6 class="mt-3 mb-2 ms-3 ">Audit Logs</h6>
                            
                        </div>

                        <div class="card-body">
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center">
                                    <thead>
                                      <tr>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="max-width: 5px">ID</th> --}}
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="max-width: 25px">User</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Event</th>
                                        <th class="text-right text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Timestamp</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr class="text-xs font-weight-bold">
                                            {{-- <td style="padding-left:25px">
                                                {{$log->id}}
                                            </td> --}}
                                            <td style="padding-left:25px">
                                                {{$log->user->email}}
                                            </td>
                                            <td>
                                                {{$log->body}}
                                            </td>
                                            <td>
                                                {{$log->created_at}}
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
            </div>
        </div>
    </div>
</div>
@endsection