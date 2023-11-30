<x-mail::message>
# Manpower request changed
<x-mail::panel>
Status:  <b>{{$manpower->active_friendly}}</b>

Job Group: <b>{{$manpower->job_group}}</b>

SJT / CSA:  <b>{{$manpower->quiz->name}}</b>

Job Title:   <b>{{$manpower->job_title}}</b>

Job Description:  <b>{{$manpower->description}}</b>

Responsibilities:   <b>{{$manpower->responsibilities}}</b>

Qualifications:  <b>{{$manpower->qualifications}}</b>

Benefits:  <b>{{$manpower->benefits}}</b>

Vancancy:  <b>{{$manpower->vacancies}}</b>

Job Nature:  <b>{{$manpower->job_nature}}</b>

Location:  <b>{{$manpower->location}}</b>

Deadline:  <b>{{$manpower->expires_at}}</b>

Required Experience:  <b>{{$manpower->required_experience}}</b>

Department:  <b>{{$manpower->department}}</b>

</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
