<?php

namespace App\Http\Controllers;

use App\Mail\JobAppliedMail;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\ManPower;
use Illuminate\Http\Request;
use App\Mail\JobInterviewMail;
use App\Models\UserJobApplication;
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
            ]);    

            $application = UserJobApplication::find($application_id);


            Session::flash('message', 'Job application sent! Please wait for our HR to contact you. Thank you.');
        }
        return redirect()->route('job.create', $id);
    }

    public function viewApplicants()
    {

        $user = auth()->user();
        if($user->role === User::APPLICANT){
            $applicants = UserJobApplication::with('user','job')
                            ->where('user_id', $user->id)
                            ->orderBy('id','desc')->get();
        }else{
            $applicants = UserJobApplication::with('user','job')->orderBy('id','desc')->get();
        }
        return view('job-applications.index',compact('applicants'));
    }

    public function sendInterview(Request $request, $id)
    {
        $applicant = UserJobApplication::with('user','job')->findOrFail($id);
        $applicant->update([
            'link'=>$request->link
        ]);
        tap($applicant);
        // Mail::to($applicant->user->email)
        //     ->send(
        //         new JobInterviewMail(
        //             $applicant
        //         )
        //     );
        $name = $applicant->user->fullname; 
        $position = $applicant->job->job_title; 
        $link = $request->link; 

        $message = "Greetings, $name.\n\nYou're scheduled for an interview for applying $position.\n\nPlease use this link as reference for the interview link: $link.\n\nYou may also check you're registered email for more information.\nThank you.";

        $sid = config('services.twilio.account_sid');
        $token = config('services.twilio.auth_token');
        $twilio_number = config('services.twilio.twilio_number');
        $client = new Client($sid, $token);
        $client->messages->create('+639685794313',
            [
                'From'=> $twilio_number,
                'body'=> $message
            ]);
        
    }
}
