<x-mail::message>
# Greetings!

@if($is_onsite)
Subject: <b>Onsite Interview </b> <br>
Dear <b>{{$application->user->fullname}}</b>,

We're excited to move forward with your application for <b>{{$application->job->job_title}}</b> role at Entrego.

Your final interview is scheduled on 
<b>{{\Carbon\Carbon::parse($application->interview_date)->toDayDateTimeString()}}</b> 
located at 
<b>{{$application->job->locationLink->value}} Office</b>



@else
Subject: Job Offer Zoom Link for <b>{{$application->user->fullname}}</b>

Dear <b>{{$application->user->fullname}}</b>,

We're excited to move forward with your application for {{$application->job->job_title}} role at Entrego. Here's the link the Zoom for the JOB OFFER:

<b><a href="{{$application->link}}">{{$application->link}}</a></b>

Your final interview is scheduled on <b>{{\Carbon\Carbon::parse($application->interview_date)->toDayDateTimeString()}}</b> <br>
Please log in a few minutes early to ensure a smooth start. If you encounter any technical issues, don't hesitate to contact us.
Looking forward to meeting you virtually!

<x-mail::button :url="$link">
Zoom Link
</x-mail::button>
@endif
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
