<?php

namespace App\Http\Controllers;

use App\Mail\JobAppliedMail;
use App\Mail\JobApprovedMail;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\ManPower;
use Illuminate\Http\Request;
use App\Mail\JobInterviewMail;
use App\Mail\JobOfferMail;
use App\Mail\JobRejectedMail;
use App\Models\UserJobApplication;
use App\Services\Semaphore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class JobApplicationController extends Controller
{
    public function index()
    {
        // return ManPower::all();
        $list = ManPower::JOB_GROUP;
        $jobs = ManPower::active()->orderBy('id','desc')->get();
        return view('public.jobs',compact('jobs','list'));
    }

    public function create($id)
    {
        $job = ManPower::findOrFail($id);
        return view('public.apply', compact('job'));
    }

    public function store($id)
    {
        
        if(!auth()->check())
        {
            Session::flash('message', 'You must be logged in to apply for this job');
            Session::flash('type', 'info');
            Session::flash('title', 'Oops..');
            return redirect()->route('job.create', $id);
        }
        $user = User::find(auth()->user()->id);
        if(!$user->has_finished_profile){
            Session::flash('message', 'Before applying for this job. You need to update your personal details first');
            Session::flash('type', 'info');
            Session::flash('title', 'Oops..');
            Session::flash('redirect', route('profile.edit'));
            return redirect()->route('job.create', $id);
        }
        
        if(!$user->hasFinishedAssessment()){
            Session::flash('message', 'Before applying for this job. You need to take personal assessment first.');
            Session::flash('type', 'info');
            Session::flash('title', 'Oops..');
            Session::flash('redirect', route('personal-assessments.create'));
            return redirect()->route('job.create', $id);
        }

        $job = ManPower::findOrFail($id);
        auditLog($user->id, "Applied for a job [$job->job_title]");
        if($job->quiz->has_passing_rate){
            $application = UserJobApplication::create([
                'man_power_id'=>$id,
                'user_id'=>$user->id,
                'status'=> UserJobApplication::WAITING_FOR_EXAM_RESULT,
                'applied_at'=>now()
            ]);    
            Mail::to($application->user->email)
            ->send(
                    new JobAppliedMail(
                        $application
                    )
                );
            Session::flash('message', 'Job application sent! Please check your e-mail for instructions on how to take exam for this job. Thank you.');
        }else{

            $application_id = UserJobApplication::create([
                'man_power_id'=>$id,
                'user_id'=>$user->id,
                'status'=> UserJobApplication::FOR_SENDING_INTERVIEW,
                'applied_at'=>now()
            ])->id;    

            $application = UserJobApplication::find($application_id);


            Session::flash('message', 'Job application sent! Please wait for our HR to contact you. Thank you.');
        }
        return redirect()->route('job.create', $id);
    }

    public function viewApplicants(Request $request)
    {

        $user = auth()->user();
        $statuses = UserJobApplication::STATUSES;
        $departments = ManPower::DEPARTMENT;
        if($user->role === User::APPLICANT){
            $applicants = UserJobApplication::with('user.requirements','job')
                            ->where('user_id', $user->id)
                            ->orderBy('id','desc')->get();
        }else{
            $applicants = UserJobApplication::with('user','job')
                                            ->when($request->q, function($q, $value){
                                                $q
                                                    ->whereRelation('user','email', 'LIKE' , "%$value%")
                                                    ->orWhereRelation('user','first_name', 'LIKE' , "%$value%")
                                                    ->orWhereRelation('user','last_name', 'LIKE' , "%$value%");
                                            })
                                            ->when($request->status,function($q, $value){
                                                $q->where('status', $value);
                                            })
                                            ->when($request->department,function($q, $value){
                                                $q
                                                ->whereRelation('job','department', $value);
                                            })
                                            ->orderBy('id','desc')->get();
        }
        return view('job-applications.index',compact('applicants', 'statuses','departments'));
    }

    public function sendInterview(Request $request, $id)
    {
        $applicant = UserJobApplication::with('user','job')->findOrFail($id);
        $fields = [
            'link'=>$request->link,
            'interview_date'=>Carbon::parse($request->datetime),
        ];
        if($request->status == 'SEND_INTERVIEW'){
            $fields['status'] = UserJobApplication::INTERVIEW_SENT;
            $fields['interview_sent_at'] = now();
        }
        if($request->status == 'JOB_OFFER'){
            $fields['status'] = UserJobApplication::JOB_OFFER;
            $fields['interview_sent_at'] = now();

        }
        
    
 

        $applicant->update($fields);

        tap($applicant);
        $email = $applicant->user->email;
        if($request->status == 'SEND_INTERVIEW'){
            Mail::to($email)
            ->send(
                new JobInterviewMail(
                    $applicant
                )
            );
            $name = $applicant->user->fullname; 
            $position = $applicant->job->job_title; 
            $link = $request->link; 

            $message = "Greetings, $name.\n\nYou're scheduled for an interview for applying $position.\n\nPlease use this link as reference for the interview link: $link.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";

            // $sid = config('services.twilio.account_sid');
            // $token = config('services.twilio.auth_token');
            // $twilio_number = config('services.twilio.twilio_number');
            // $client = new Client($sid, $token);
            // $client->messages->create('+639685794313',
            //     [
            //         'From'=> $twilio_number,
            //         'body'=> $message
            //     ]);
            if(env('APP_ENV') != 'local'){
                $client = new Semaphore(config('services.semaphore.api_key'));
                $res = $client->sendSMS($applicant->user->contact_number, $message);
                auditLog($applicant->user->id, "SMS sent for Interview Link");
            }


            auditLog($applicant->user->id, "E-mail sent for Interview Link");
        }

        if($request->status =='JOB_OFFER'){
            Mail::to($email)
            ->send(
                new JobOfferMail(
                    $applicant
                )
            );
            $name = $applicant->user->fullname; 
            $position = $applicant->job->job_title; 
            $link = $request->link; 

            $message = "Greetings, $name.\n\nCongratulations! You're scheduled for the JOB OFFER for your job application -  $position.\n\nPlease use this link as reference for the interview link: $link.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";

            // $sid = config('services.twilio.account_sid');
            // $token = config('services.twilio.auth_token');
            // $twilio_number = config('services.twilio.twilio_number');
            // $client = new Client($sid, $token);
            // $client->messages->create('+639685794313',
            //     [
            //         'From'=> $twilio_number,
            //         'body'=> $message
            //     ]);
            if(env('APP_ENV') != 'local'){
                $client = new Semaphore(config('services.semaphore.api_key'));
                $res = $client->sendSMS($applicant->user->contact_number, $message);
                auditLog($applicant->user->id, "SMS sent for Job Offer Link");
            }


            auditLog($applicant->user->id, "E-mail sent for Job Offer Link");
        }
       

        return response()->json(['data'=>[]], 200);
    }

    public function patch(Request $request, $id)
    {
        $user_job = UserJobApplication::with('user','job')->findOrFail($id);
        $status = $request->status;
        $name = $user_job->user->fullname;
        $job = $user_job->job;
        
        
        $client = new Semaphore(config('services.semaphore.api_key'));

        if($request->status === UserJobApplication::REJECTED){
            Mail::to($user_job->user->email)
                ->send(
                    new JobRejectedMail($user_job)
                );
            $message = "Hi, $name\n\nWe regret to inform you that we have chosen to move forward with another candidate for the position you applied for. We appreciate your interest in our company and wish you the best in your job search.\n\nThank you,\nEntregoHR";
            $client->sendSMS($user_job->user->contact_number, $message);
            $user_job->update(['rejected_at'=>now()]);

            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - REJECTED", $user_job);
        }elseif($request->status === UserJobApplication::APPROVED){
            Mail::to($user_job->user->email)
            ->send(
                new JobApprovedMail($user_job)
            );
            $message = "Greetings, $name\n\nWe're excited to move forward with your application process.\n\nPlease upload the required documents on the Requirements Tab on your profile page.\nEach of your uploaded files will be checked and validated by our Team.\n\nWe will update you after those requirements are accepted..\n\nThank you,\nEntregoHR";
            $client->sendSMS($user_job->user->contact_number, $message);
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - APPROVE", $user_job);
            $user_job->update(['approved_at'=>now()]);


        }

        if($request->status == UserJobApplication::FOR_REQUIREMENTS){
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - FOR REQUIREMENTS", $user_job);
        }

        if($status == UserJobApplication::DEPLOYED){
            $status = UserJobApplication::DEPLOYED;
            $request->replace(['status' => $status]);
            $message = "Greetings, $name\n\nYou are now deployed as $job->job_title.\n\nThank you,\nEntregoHR" ;
            $client->sendSMS($user_job->user->contact_number, $message);
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - DEPLOYED", $user_job);
            $user_job->update(['deployed_at'=>now()]);

        }
        $user_job->update($request->all());
        
    }
}