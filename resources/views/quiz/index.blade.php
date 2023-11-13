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
                                <h6 class="mt-3 mb-2 ms-3 ">Quizzes</h6>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('quiz.create') }}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Quiz</a>
                            <p> &nbsp; </p>
                            <div class="card">
                              <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Job Group </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> # of Questions </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Has passing </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Passing Rate </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Created by </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Created at </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $quiz)
                                      <tr>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->name }}</span>

                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->job_group }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->questions_count }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->has_passing_rate_name }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->passing_rate_name }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->createdBy->fullname }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                          <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $quiz->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="align-middle">
                                          <a href="{{route('quiz.edit', $quiz->id)}}" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                              <i class="material-icons">edit</i>
                                          </a>                                           
                                          {{-- <a href="{{route('quiz.edit', $quiz->id)}}" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                              <i class="material-icons">remove_red_eye</i>
                                          </a>                                            --}}
                                          {{-- <a href="{{route('quiz.edit', $quiz->id)}}" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                              <i class="material-icons">lightbulb_outline
                                              </i>
                                          </a>    --}}
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