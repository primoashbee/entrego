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
                                <i class="material-icons opacity-10" aria-hidden="true">group</i>
                            </div>
                                                    
                            @if(request()->route()->getName() === "users.index")
                                <h6 class="mt-3 mb-2 ms-3 ">Users</h6>
                            @else
                                <h6 class="mt-3 mb-2 ms-3 ">Applicants</h6>
                            @endif
                            
                        </div>

                        <div class="card-body">
                        
                            @if(request()->route()->getName() === "users.index")
                            <a href="{{route('users.create')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New User</a>
                            <div class="float-right">&nbsp;</div><br>
                            @endif
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                        {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact Number</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                                        <th class="text-secondary opacity-7">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                      <tr>
                                        <td>
                                          <div class="d-flex px-2 py-1">
                                            {{-- <div>
                                              <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                            </div> --}}
                                            <div class="d-flex flex-column justify-content-center">
                                              <h6 class="mb-0 text-xs">{{ $user->fullname }}</h6>
                                              <p class="text-xs text-secondary mb-0"> {{$user->email}} </p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <p class="text-xs font-weight-bold mb-0">{{ $user->role }}</p>
                                          {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                          <span class="badge badge-sm badge-success"> {{$user->contact}} </span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-secondary text-xs font-weight-normal"> {{ $user->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="align-middle">
                                          <a href="{{route('users.edit', $user->id)}}" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                            Edit
                                          </a>
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