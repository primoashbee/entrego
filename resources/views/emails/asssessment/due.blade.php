<x-mail::message>
# Greetings!

Subject: Personal Assessment</b>

Dear <b>{{$user->fullname}}</b>,
Your account has been tagged as {{$user->archiveStatus()}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
