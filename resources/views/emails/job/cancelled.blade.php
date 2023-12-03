<x-mail::message>
Subject: Job Application Status

Dear {{$application->user->fullname}},

Your job cancellation is <b>CANCELLED</b> <br>

Reason: {{$application->cancelled_notes}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
