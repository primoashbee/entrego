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
                                                    
                            <h6 class="mt-3 mb-2 ms-3 ">Personal Assessments</h6>
                            
                        </div>

                        <div class="card-body">
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Extraversion</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Agreeableness</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Conscientiousness</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Neuroticism</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Openness</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Taken</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        {{-- <th class="text-secondary opacity-7">Action</th> --}}
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 mt-2">{{ $item->user->fullname }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 mt-2">{{ $item->user->email }}</p>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-secondary" style="width: {{$item->extraversion_percentage}}%; height:20px">{{$item->extraversion_percentage}}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" style="width: {{$item->agreeableness_percentage}}%; height:20px">{{$item->agreeableness_percentage}}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" style="width: {{$item->conscientiousness_percentage}}%; height:20px">{{$item->conscientiousness_percentage}}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" style="width: {{$item->neuroticism_percentage}}%; height:20px">{{$item->neuroticism_percentage}}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-info" style="width: {{$item->openness_percentage}}%; height:20px">{{$item->openness_percentage}}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 mt-2">{{ $item->user->created_at->diffForHumans() }}</p>
                                            </td>
                                            <td>
                                                <a href="{{route('personal-assessments.show', $item->batch_id)}}" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">edit</i>
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