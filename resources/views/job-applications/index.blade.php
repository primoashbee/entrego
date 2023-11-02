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
                            
                            {{-- <div class="input-group input-group-outline my-3" style="max-width: 300px">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control"  style="float: right; margin-bottom: 0%">
                                <button class="btn-primary">Search</button>
                            </div> --}}
                            <form action="{{url()->current()}}" method="GET" id="frmFilter" onsubmit="submitFilter">
                                <div class="row"> 
                                    <div class="col-2">
                                        <div class="input-group input-group-outline mb-3">
                                            <select name="status" id="status" class="form-control form-filter" placeholder="Status">
                                                <option value="">Select Status</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{$status['value']}}">{{$status['label']}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <select name="department" id="department" class="form-control form-filter" placeholder="department">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{$dept['value']}}">{{$dept['label']}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-3">
                                        <div class="input-group input-group-outline mb-3">
                                            <input type="text" class="form-control form-filter" style="height:42px" placeholder="Search"  name="q" value="{{request()->q}}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                              

                              
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
                                                @elseif($applicant->status=='FOR_REQUIREMENTS')
                                                <span class="badge bg-gradient-info">{{ $applicant->status_name }} {{$applicant->user->requirement_summary}} </span> <br> 
                                                <a href="{{route('requirements.index',['ids'=>implode(',',$applicant->user->requirements->pluck('id')->toArray())])}}" class="text-xs font-weight-bold mb-0">Click to View</a>
                                                @elseif($applicant->status=='DEPLOYED')
                                                <span class="badge bg-gradient-success">{{ $applicant->status_name }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if(!auth()->user()->isApplicant())

                                                    <a href="javascript:void(0)" onclick="promptEmail({{$applicant->id}})" class="font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                        <i class="material-icons">mail</i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="promptStatus({{$applicant->id}}, 'REJECTED')" class="font-weight-normal text-xs text-danger" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">cancel</i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="promptStatus({{$applicant->id}}, 'APPROVED')" class="font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">check_circle</i>
                                                    </a>
                                                    @if($applicant->canBeDeployed())
                                                    <a href="javascript:void(0)" onclick="promptStatus({{$applicant->id}}, 'DEPLOYED')" class="font-weight-normal text-xs text-warning" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">work</i>
                                                    </a>
                                                    @endif
                                                @else
                                                    <!-- This means currently logged in is applicant !-->
                                                    @if($applicant->userQuiz)
                                                        <a href="{{route('user-quiz.view-result', $applicant->id)}}" class="font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                            <i class="material-icons">question_answer</i>
                                                        </a>
                                                    @else
                                                    <a href="{{route('user-quiz.take', $applicant->id)}}" class="font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
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
        if(!url){
            return;
        }
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
        day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day +'T00:00'  ;
        const { value: datetime } = await Swal.fire({
            title: 'Date & Time',
            html: `<input class="swal2-input" type="datetime-local" id="datetime" name="datetime" min='${maxDate}'>`,
            focusConfirm: false,
            preConfirm: () => {
                const datepicked = new Date(document.getElementById('datetime').value)
                const maxDate = new Date(new Date())
                if (datepicked < maxDate) {
                    Swal.showValidationMessage(`The interview date can't be in the past`)
                }
                return datepicked
            }
        })

        if (url && datetime) {
            const response = await Swal.fire({
                title: 'Confirmation',
                text: "Are you sure the zoom link is correct?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            })

            if(response.isConfirmed){
                let alert = Swal.fire({
                    title: 'Processing',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

                await sendInterview(id, url, datetime)
                alert.close()

                await Swal.fire(
                    'Success!',
                    'Interview details sent!',
                    'success'
                )
                
            }
        }

    }
    async function sendInterview(id, link,datetime){
        const payload = {
            link: link,
            datetime: datetime
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

    async function promptStatus(id, status){
        const response = await Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want this application ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            })

        if(!response.isConfirmed){
            return false;

        }
        let alert = Swal.fire({
                    title: 'Processing',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

        const res = await fetch(`/job/${id}`, {
          'method': 'PATCH',
          'body': JSON.stringify({status:status}),
          'headers': {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": '{{csrf_token()}}',
          },
          'content-type': 'application/json'
        })

        alert.close()
        
        await Swal.fire(
            'Success!',
            'Job Application updated. An e-mail was sent to the applicant instructions',
            'success'
        )
    }

    (function () {
        document.getElementById('status').value = '{{request()->status}}'
        document.getElementById('department').value = '{{request()->department}}'
    })();

    document.getElementById('frmFilter').onsubmit = (e) => {
        Array.from(document.getElementsByClassName('form-filter')).forEach(element => {
            if(element.value == ""){
                element.remove()
            }
        });
    }

   
</script>
@endsection