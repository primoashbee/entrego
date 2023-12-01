<x-mail::message>
# Greetings!

@if($is_onsite)
Subject: <b>Onsite Interview </b> <br>
Dear <b>{{$applicant->user->fullname}}</b>,

We're excited about your upcoming interview for the 
    <b>{{$applicant->job->job_title}} </b> role at Entrego.
Your interview is scheduled on 
    <b>{{\Carbon\Carbon::parse($applicant->interview_date)->toDayDateTimeString()}}</b> 
located at 
<b>{{$applicant->job->locationLink->value}} Office</b>



@else
Subject: Interview Zoom Link for <b>{{$applicant->user->fullname}}</b>

Dear <b>{{$applicant->user->fullname}}</b>,

We're excited about your upcoming interview for the {{$applicant->job->job_title}} role at Entrego. Here's the link the Zoom interview:

<b><a href="{{$applicant->link}}">{{$applicant->link}}</a></b>

Your interview is scheduled on <b>{{\Carbon\Carbon::parse($applicant->interview_date)->toDayDateTimeString()}}</b> <br>
Please log in a few minutes early to ensure a smooth start. If you encounter any technical issues, don't hesitate to contact us.
Looking forward to meeting you virtually!

<x-mail::button :url="$link">
Zoom Link
</x-mail::button>
@endif



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
