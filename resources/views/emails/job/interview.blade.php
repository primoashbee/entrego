<x-mail::message>
# Greetings!

Subject: Interview Zoom Link for {{$applicant->user->fullname}}

Dear {{$applicant->user->fullname}},

We're excited about your upcoming interview for the {{$applicant->job->job_title}} role at Entrego. Here's the link the Zoom interview:

{{$applicant->link}}

Please log in a few minutes early to ensure a smooth start. If you encounter any technical issues, don't hesitate to contact us.
Looking forward to meeting you virtually!

Best regards,

<x-mail::button :url="$link">
Zoom Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
