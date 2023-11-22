<x-mail::message>
# Greetings!

Subject: Your Exam Link - <b>{{$application->job->job_title}} Exam</b>

Dear <b>{{$application->user->fullname}}</b>,

I hope this message finds you well. It's time for your {{$application->job->job_title}} exam! To access the exam, simply click on the link below:

<a href="{{route('user-quiz.take', $application->id)}}">{{route('user-quiz.take', $application->id)}}</a>

Please make sure to complete the exam within the allotted time frame. If you encounter any technical issues or have questions about the exam, don't hesitate to reach out to us.

Best of luck, and I'm confident you'll do great!


<x-mail::button :url="route('user-quiz.take', $application->id)">
Exam link
</x-mail::button>

Sincerely,

Entrego HR

</x-mail::message>
