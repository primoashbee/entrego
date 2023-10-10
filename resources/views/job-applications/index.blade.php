@extends('layouts.user')
@section('content')
<div class="container-fluid py-4" id="div-view">
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
                            <h6 class="mt-3 mb-2 ms-3 "> Job Applications </h6>
                        </div>

                        <div class="card-body">
                            <a href="{{route('job.listing')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">View Job Listing</a>
                            <div class="float-right">&nbsp;</div><br>
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Job</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Exam</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applicants as $applicant)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                  <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs">{{ $applicant->user->fullname }}</h6>
                                                    <p class="text-xs text-secondary mb-0"> {{$applicant->user->email}} </p>
                                                  </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                  <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs">{{ $applicant->job->job_title }}</h6>
                                                    <p class="text-xs text-secondary mb-0"> {{$applicant->job->job_group}} </p>
                                                  </div>
                                                </div>
                                            </td>
                                            <td class=" text-center">
                                                @if($applicant->userQuiz)

                                                    <div class="progress" style="width:100%; margin-top:-8px">
                                                        @if($applicant->userQuiz->percentage < 50)
                                                            <div class="progress-bar bg-gradient-danger text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}%</div>
                                                        @elseif($applicant->userQuiz->percentage >= 50 &&  $applicant->userQuiz->percentage <= 75)
                                                            <div class="progress-bar bg-gradient-secondary text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}%</div>
                                                        @else
                                                            <div class="progress-bar bg-gradient-success text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}%</div>    
                                                        @endif
                                                    </div>

                                                    @else
                                                        N/A
                                                    @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($applicant->status == 'WAITING_FOR_EXAM_RESULT')
                                                <span class="badge bg-gradient-secondary">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='EXAM_PASSED')
                                                <span class="badge bg-gradient-success">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='EXAM_FAILED')
                                                <span class="badge bg-gradient-danger">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='INTERVIEW_SENT')
                                                <span class="badge bg-gradient-info">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='FOR_SENDING_INTERVIEW')
                                                <span class="badge bg-gradient-info">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='REJECTED')
                                                <span class="badge bg-gradient-danger">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='APPROVED')
                                                <span class="badge bg-gradient-success">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='HIRED')
                                                <span class="badge bg-gradient-success">{{ $applicant->status_name }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if(!auth()->user()->isApplicant())

                                                <a href="javascript:void(0)" onclick="promptEmail({{$applicant->id}})" class="text-secondary font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                    <i class="material-icons">mail</i>
                                                </a>
                                                <a href="#" class="text-secondary font-weight-normal text-xs text-danger" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <a href="#" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">check_circle</i>
                                                </a>
                                                
                                                @else
                                                    <!-- This means currently logged in is applicant !-->
                                                    @if($applicant->userQuiz)
                                                        <a href="{{route('user-quiz.view-result', $applicant->id)}}" class="text-secondary font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                            <i class="material-icons">question_answer</i>
                                                        </a>
                                                    @else
                                                    <a href="{{route('user-quiz.take', $applicant->id)}}" class="text-secondary font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                        <i class="material-icons">laptop</i>
                                                    </a>
                                                    @endif
                                                @endif

                                           
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


@section('scripts')
<script>
    async function promptEmail(id){
        const { value: url } = await Swal.fire({
                                    input: 'url',
                                    inputLabel: 'Enter zoom URL',
                                    inputPlaceholder: 'Enter the URL'
                                })

        if (url) {
            const response = await Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })

            if(response.isConfirmed){
                let alert = Swal.fire({
                    title: 'Processing',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

                await sendInterview(id, url)

                alert.close()

                await Swal.fire(
                    'Success!',
                    'Interview details sent!',
                    'success'
                )
                
            }
        }

    }
    async function sendInterview(id, link){
        const payload = {
            link: link
        }
        const res = await fetch(`/job/send-interview/${id}`, {
            'method': 'POST',
            'body': JSON.stringify(payload),
            'headers': {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
            },
            'content-type': 'application/json'
            })

    }
</script>
@endsection