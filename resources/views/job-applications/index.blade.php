@extends('layouts.user')
@section('content')
<div class="container-fluid py-4" id="div-view">
    @include('components.errors')
    <div class="row">
        
        <div class="col-lg-12 position-relative z-index-2">
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
                            <form action="{{url()->current()}}" method="GET" id="frmFilter">
                                <div class="row"> 
                                    <div class="col-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>From Date</label>
                                            <input type="date" class="form-control form-filter" name="start_date" id="start_date"  >
                                          </div>                                    
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>End Date</label>
                                            <input type="date" class="form-control form-filter" name="end_date" id="end_date"  >
                                          </div>                                    
                                    </div>
                                    <div class="col-7"></div>
                                    <div class="col-1">
                                        <button class="btn btn-lg btn-success mt-3" type="submit" value="export" name="export"><i class="material-icons">print</i></button>
                                    </div>

                                </div>
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
                                            <input type="text" class="form-control form-filter" style="height:42px" placeholder="Search"  name="q" id="q" value="{{request()->q}}">
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
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Personal Assessment</th>
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
                                                    <p class="text-xs text-secondary mb-0"> {{$applicant->job->job_group}} | {{$applicant->job->department_name}}</p>
                                                  </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">

                                                @if($applicant->user->assessments()->count() > 0)
                                                <span class="badge bg-gradient-success"> Finished </span> <br> 
                                                <a href="{{route('personal-assessments.view', $applicant->user->assessments()->first()->batch_id)}}" class="text-xs font-weight-bold mb-0">Click to View</a>

                                                @else
                                                <span class="badge bg-gradient-default"> Pending </span> <br> 

                                                @endif

                                            </td>
                                            <td class=" text-center">
                                                @if($applicant->userQuiz)

                                                    {{-- <div class="progress" style="width:100%; margin-top:-8px"> --}}
                                                        {{-- @if($applicant->userQuiz->percentage < 50)
                                                            <div class="progress-bar bg-gradient-danger text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}% </div>
                                                        @elseif($applicant->userQuiz->percentage >= 50 &&  $applicant->userQuiz->percentage <= 75)
                                                            <div class="progress-bar bg-gradient-secondary text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}%</div>
                                                        @else
                                                            <div class="progress-bar bg-gradient-success text-center" style="width: {{$applicant->userQuiz->percentage}}%; height:20px">{{$applicant->userQuiz->percentage}}%</div>    
                                                        @endif --}}
                                                        @if($applicant->userQuiz->is_passed)
                                                        <span class="badge bg-gradient-success"> Passed </span> <br> 
                                                        @else
                                                        <span class="badge bg-gradient-danger"> Failed </span> <br> 
                                                        @endif
                                                        <a href="{{route('user-quiz.view-result', $applicant->id)}}" class="text-xs font-weight-bold mb-0">Click to View</a>



                                                    {{-- </div> --}}
     

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
                                                @elseif($applicant->status=='JOB_OFFER')
                                                <span class="badge bg-gradient-secondary">{{ $applicant->status_name }}</span>
                                                @elseif($applicant->status=='DEPLOYED')
                                                <span class="badge bg-gradient-success">{{ $applicant->status_name }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if(!auth()->user()->isApplicant())
                                                    <!-- Step 1 Send Interview Mail -->
                                                    <a href="javascript:void(0)" onclick="promptEmail({{$applicant->id}}, 'SEND_INTERVIEW')" class="font-weight-normal text-xs text-info" data-toggle="tooltip" data-original-title="Send interview email" tooltip="send intrer">
                                                        <i class="material-icons">mail</i>
                                                    </a>
                                                    <!-- Step X Reject Application  Can be done everytime -->
                                                    <a href="javascript:void(0)" onclick="promptStatus({{$applicant->id}}, 'REJECTED')" class="font-weight-normal text-xs text-danger" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">cancel</i>
                                                    </a>

                                                    <!-- Step 2 Job Offer -->
                                                    <a href="javascript:void(0)" onclick="promptEmail({{$applicant->id}}, 'JOB_OFFER')" class="font-weight-normal text-xs text-primary" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">event_available</i>
                                                    </a>

                                                    <!-- Step 3 Job Offer Approved - Applicant will now be FOR Requirements -->
                                                    <a href="javascript:void(0)" onclick="promptStatus({{$applicant->id}}, 'APPROVED')" class="font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                                        <i class="material-icons">check_circle</i>
                                                    </a>

                                                    @if($applicant->user->canBeZipped() && $applicant->user->requirementsFullfilled() && $applicant->status == \app\Models\UserJobApplication::FOR_REQUIREMENTS )
                                                    <!-- Deployment -->
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

                                                @if($applicant->user->canBeZipped())
                                                <a href="javascript:void(0)" onclick="promptDownloadUserReport({{$applicant->user_id}})"  data-toggle="tooltip"  class="font-weight-normal text-xs text-success">
                                                 <i class="material-icons">file_download</i>
                                                </a>
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
    async function promptEmail(id, status){
        const status_text = status.replace("_", " ")
        const { value: url } = await Swal.fire({
                                    input: 'url',
                                    inputLabel: `Enter zoom URL (${status_text})`,
                                    inputPlaceholder: `Enter zoom URL (${status_text})`
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

                await sendInterview(id, url, datetime, status)
                alert.close()

                await Swal.fire(
                    'Success!',
                    'Interview details sent!',
                    'success'
                )
                
            }
        }

    }
    async function sendInterview(id, link,datetime, status){
        const payload = {
            link: link,
            datetime: datetime,
            status: status
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
        title = 'Confirmation'
        const status_text = status.replace("_", " "); 
        text = `Are you sure you want this application ${status_text}?`

        if(status=='APPROVED'){
            status = 'FOR_REQUIREMENTS'
            title = 'Accept Job Offer'
            text = `Do you want to tag this applicant FOR REQUIREMENTS?`
        }
        if(status=='DEPLOYED'){
            title = 'Deploy Application'
            text = `Do you want to tag this applicant as DEPLOYED?`

        }
        if(status=='REJECTED'){
            title ='Reject Application'
            text = `Do you want to tag this applicant as REJECTED?`

        }

        const response = await Swal.fire({
                title: title,
                text: text,
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

    async function promptDownloadUserReport(id){
        const response = await Swal.fire({
                title: 'Applicant Report',
                text: `Download application report? This may some time to process.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
        })

        if(!response.isConfirmed){
            return;
        }
        const url= `/user/packet/${id}`;
        window.location.href = url
    }

    (function () {
        document.getElementById('status').value = '{{request()->status}}'
        document.getElementById('department').value = '{{request()->department}}'

        document.getElementById('start_date').value = "{{request()->start_date == '' ? old('start_date') : request()->start_date }}"
        document.getElementById('end_date').value = "{{request()->end_date == '' ? old('end_date') : request()->end_date}}"
    })();

   
    document.getElementById('frmFilter').addEventListener("submit", function(event){
     
        Array.from(document.getElementsByClassName('form-filter')).forEach(element => {
            if(element.value == "" ){
                element.disabled=true
            }
        });

    })

   
</script>
@endsection