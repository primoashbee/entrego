<x-mail::message>
Subject: <b>{{$application->job->job_title}}</b> Application - Uploading Required Documents

Dear {{$application->user->fullname}},

We're excited to move forward with your application process. 

Please upload the required documents on the <b>Requirements Tab</b> on your profile page
Each of your uploaded files will be checked and validated by our Team.

We will update you after those requirements are accepted.

<x-mail::button :url="route('profile.edit')">
My Profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
