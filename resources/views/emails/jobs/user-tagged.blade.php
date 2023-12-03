<x-mail::message>
# Update

Subject: <b>Job Update </b> <br>
Application: <b>{{$application->user->full_name}}</b> <br>
Job Title: <b>{{$application->job->job_title}}</b> <br>

Dear <b>{{$tagged_user->full_name}}</b>, <br><br>

@if($type == 'SEND_INTERVIEW')
You have been assigned on the <b>JOB INTERVIEW</b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
    Date: <b> {{\Carbon\Carbon::parse($application->interview_date)->format('F d, Y g:iA')}} </b> <br>
    @if($application->send_interview_onsite)
    Location: <b>{{$application->job->locationLink->value}} Office (Onsite)</b> <br>
    @else
    Location:
        <b><a href="{{$application->link}}"> Interview Link (Online) </a></b>
        <x-mail::button :url="$application->link">
            Zoom Link
        </x-mail::button>
    @endif
@endif

@if($type == 'JOB_OFFER')
You have been assigned on the <b>FINAL INTERVIEW</b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
    Date: <b> {{\Carbon\Carbon::parse($application->job_offered_at)->format('F d, Y g:iA')}} </b> <br>
    @if($application->job_offer_interview_onsite)
    Location: <b>{{$application->job->locationLink->value}} Office (Onsite)</b> <br>
    @else
    Location:
        <b><a href="{{$application->link}}"> Interview Link (Online) </a></b>
        <x-mail::button :url="$application->link">
            Zoom Link
        </x-mail::button>
    @endif
@endif

@if($type == 'APPROVED')
You have been assigned to the <b>JOB APPROVAL</b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
@endif

@if($type == 'FOR_REQUIREMENTS')
You have been assigned to the <b> REQUIREMENTS CHECKING</b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
@endif

@if($type == 'DEPLOYED')
You have been assigned to the <b> DEPLOYMENT</b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
@endif

@if($type == 'REJECTED')
You have been assigned to the <b> REJECTION </b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
@endif

@if($type == 'CANCELLED')
You have been assigned to the <b> CANCELLATION </b> of: <br>
    Name: <b>{{$application->user->full_name}}</b> <br> 
    Job: <b>{{$application->job->job_title}} </b> <br>
@endif


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
