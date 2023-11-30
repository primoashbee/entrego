<x-mail::message>
# Greetings!

Subject: Account Status </b>

Dear <b>{{$user->fullname}}</b>,

Your account <b> {{ $user->email}} </b> has been tagged as <b>{{$user->archiveStatus()}}</b>

If you have questions please send us an e-mail.
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
