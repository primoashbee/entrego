<x-mail::message>
# Greetings!

Subject: Job Offer Zoom Link for <b>{{$application->user->fullname}}</b>

Dear <b>{{$application->user->fullname}}</b>,

We're excited to present you the JOB OFFER for  {{$application->job->job_title}} role at Entrego. Here's the link the Zoom for the JOB OFFER:

<b><a href="{{$application->link}}">{{$application->link}}</a></b>

Your interview is scheduled on <b>{{\Carbon\Carbon::parse($application->interview_date)->toDayDateTimeString()}}</b> <br>
Please log in a few minutes early to ensure a smooth start. If you encounter any technical issues, don't hesitate to contact us.
Looking forward to meeting you virtually!

Best regards,

<x-mail::button :url="$link">
Zoom Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
