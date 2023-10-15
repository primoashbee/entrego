<x-mail::message>
Subject: Job Application Status

Dear {{$application->user->fullname}},

We regret to inform you that we have chosen to move forward with another candidate for the position you applied for. We appreciate your interest in our company and wish you the best in your job search.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
