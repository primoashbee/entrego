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
                                                    
                            @if(request()->route()->getName() === "quiz.index")
                                <h6 class="mt-3 mb-2 ms-3 ">Quizzes</h6>
                            @else
                                <h6 class="mt-3 mb-2 ms-3 ">Applicants</h6>
                            @endif
                            
                        </div>

                        <div class="card-body">
                            <a href="{{ route('quiz.create') }}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Quiz</a>
                            <p> &nbsp; </p>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                  <thead>
                                    <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                      {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Job Group </th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Passing Rate </th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Created At </th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($list as $user)
                                    <tr>

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
@endsection