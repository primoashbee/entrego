<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\ManPower;
use App\Mail\JobOfferMail;
use App\Services\Semaphore;
use Illuminate\Support\Str;
use App\Mail\JobAppliedMail;
use Illuminate\Http\Request;
use App\Mail\JobApprovedMail;
use App\Mail\JobRejectedMail;
use App\Mail\JobInterviewMail;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ApplicantsRequest;
use App\Mail\JobApplicationTagged;
use App\Mail\JobCancelledMail;
use App\Models\Department;

class JobApplicationController extends Controller
{
    public function index()
    {
        // return ManPower::all();
        $list = Department::select('key','value')->orderBy('value','asc')->get();
        $jobs = ManPower::active()->where('expires_at', '>' ,now())->orderBy('id','desc')->get();
        return view('public.jobs',compact('jobs','list'));
    }

    public function create($id)
    {
        $job = ManPower::findOrFail($id);
        return view('public.applyv2', compact('job'));
    }

    public function createv2($id)
    {
        $job = ManPower::findOrFail($id);
        return view('public.applyv2', compact('job'));
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
        if($job->has_sjt && $job->quiz->has_passing_rate){
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

    public function viewApplicants(ApplicantsRequest $request)
    {

        $for_report = $request->has('export');
        // dd($request->all());
        if($for_report){
            // return $this->showReport(compact('applicants', 'statuses','departments'));
            //Goes to $this->viewReport
            return redirect()->route('user-job.report', $request->query());
        }

        $user = auth()->user();
        $statuses = UserJobApplication::STATUSES;
        $departments = Department::select('key','value')->orderBy('id','desc')->get();
        $jobs = ManPower::select('id','job_title')->get();
        
        if($user->role == User::ADMINSTRATOR){
            $staffs = User::select('id','first_name','last_name','email','role')->whereNotIn('role',[User::APPLICANT, User::SUB_HR])->get();
        }

        if($user->role == User::SUB_HR){
            $staffs = User::select('id','first_name','last_name','email','role')
                ->where('role',User::HR)
                ->orWhere('id', $user->id)
                ->get();
        }

        if($user->role == User::HR){
            $staffs =  User::where('id', $user->id)
            ->get();
        }

        
        if($user->role == User::APPLICANT){
            $staffs =  User::where('id', $user->id)
            ->get();
        }

        
        if($user->role === User::APPLICANT){
            $applicants = UserJobApplication::with('user.requirements','job')
                            ->where('user_id', $user->id)
                            ->orderBy('id','desc')
                            ->paginate(10);
            $deployed = UserJobApplication::with('user.requirements','job')
                            ->where('user_id', $user->id)
                            ->where('status', UserJobApplication::DEPLOYED)
                            ->orderBy('id','desc')
                            ->paginate(10);

        }else{
            // $applicants = UserJobApplication::with('user','job')
            //                                 ->when($request->q, function($q, $value){
            //                                     $q
            //                                         ->whereRelation('user','email', 'LIKE' , "%$value%")
            //                                         ->orWhereRelation('user','first_name', 'LIKE' , "%$value%")
            //                                         ->orWhereRelation('user','last_name', 'LIKE' , "%$value%");
            //                                 })
            //                                 ->when($request->status,function($q, $value){
            //                                     $q->where('status', $value);
            //                                 })
            //                                 ->when($request->department,function($q, $value){
            //                                     $q
            //                                     ->whereRelation('job','department', $value);
            //                                 })
            //                                 ->orderBy('id','desc')->get();
            $is_dept_head = $user->role == User::SUB_HR;
            $applicants = $this->generateList($request, $for_report, $is_dept_head, $user->id);
            $deployed = $this->deployedList($request, $for_report, $is_dept_head,$user->id);
        }


        return view('job-applications.index',compact('applicants', 'statuses','departments','deployed','jobs','staffs'));
    }

    public function viewAplicantsByType(ApplicantsRequest $request, $type)
    {

        $for_report = $request->has('export');
        // dd($request->all());
        if($for_report){
            // return $this->showReport(compact('applicants', 'statuses','departments'));
            //Goes to $this->viewReport
            // dd($request->query());
           
            $params = $request->query();
            $params['type'] = $type;
            return redirect()->route('user-job.report-type', $params);
        }

        $user = auth()->user();
        $statuses = UserJobApplication::STATUSES;
        $departments = Department::select('key','value')->orderBy('id','desc')->get();
        $jobs = ManPower::select('id','job_title')->get();
        
        if($user->role == User::ADMINSTRATOR){
            $staffs = User::select('id','first_name','last_name','email','role')->whereNotIn('role',[User::APPLICANT, User::SUB_HR])->get();
        }

        if($user->role == User::SUB_HR){
            $staffs = User::select('id','first_name','last_name','email','role')
                ->where('role',User::HR)
                ->orWhere('id', $user->id)
                ->get();
        }

        if($user->role == User::HR){
            $staffs =  User::where('id', $user->id)
            ->get();
        }

        
        if($user->role == User::APPLICANT){
            $staffs =  User::where('id', $user->id)
            ->get();
        }

        
        if($user->role === User::APPLICANT){
            $applicants = UserJobApplication::with('user.requirements','job')
                            ->where('user_id', $user->id)
                            ->when($type, function($q, $value) use ($type){
                                if($value === 'in-progress'){
                                    return $q->whereIn('status', UserJobApplication::IN_PROGRESS);
                                }
                                if($value === 'deployed'){
                                    return $q->whereIn('status', [UserJobApplication::DEPLOYED]);
                                }
                                if($value === 'rejected'){
                                    return $q->whereIn('status', [UserJobApplication::REJECTED]);
                                }
                
                                if($value === 'cancelled'){
                                    return $q->whereIn('status', [UserJobApplication::CANCELLED]);
                                }                                
                                // return $q->whereIn('status', UserJobApplication::IN_PROGRESS);
                            })
                            ->orderBy('id','desc')
                            ->paginate(10);
            $deployed = UserJobApplication::with('user.requirements','job')
                            ->where('user_id', $user->id)
                            ->when($type, function($q, $value){
                                return $q->whereIn('status', [UserJobApplication::DEPLOYED]);
                            })
                            // ->where('status', UserJobApplication::DEPLOYED)
                            ->orderBy('id','desc')
                            ->paginate(10);

        }else{
            // $applicants = UserJobApplication::with('user','job')
            //                                 ->when($request->q, function($q, $value){
            //                                     $q
            //                                         ->whereRelation('user','email', 'LIKE' , "%$value%")
            //                                         ->orWhereRelation('user','first_name', 'LIKE' , "%$value%")
            //                                         ->orWhereRelation('user','last_name', 'LIKE' , "%$value%");
            //                                 })
            //                                 ->when($request->status,function($q, $value){
            //                                     $q->where('status', $value);
            //                                 })
            //                                 ->when($request->department,function($q, $value){
            //                                     $q
            //                                     ->whereRelation('job','department', $value);
            //                                 })
            //                                 ->orderBy('id','desc')->get();
            $is_dept_head = $user->role == User::SUB_HR;
            $applicants = $this->generateList($request, $for_report, $is_dept_head, $user->id, $type);
            $deployed = $this->deployedList($request, $for_report, $is_dept_head,$user->id, $type);
        }
        return view('job-applications.index-type',compact('applicants', 'statuses','departments','deployed','jobs','staffs'));
    }

    public function sendInterview(Request $request, $id)
    {
    
        $applicant = UserJobApplication::with('user','job')->findOrFail($id);
        $status = $request->status;
        $fields = [
            'link'=>$request->link,
            'interview_date'=>Carbon::parse($request->datetime),
        ];
        $tagged_id = $request->hr_id;
        if($request->status == 'SEND_INTERVIEW'){
            $fields['status'] = UserJobApplication::INTERVIEW_SENT;
            $fields['interview_sent_at'] = now();
            $fields['send_interview_notes'] = $request->notes;
            $fields['send_interview_onsite'] = $request->is_onsite;
            $fields['interviewed_by'] = $request->hr_id;
        }
        if($request->status == 'JOB_OFFER'){
            $fields['status'] = UserJobApplication::JOB_OFFER;
            $fields['job_offered_at'] = now();
            $fields['job_offer_interview_onsite'] = $request->is_onsite;
            $fields['job_offer_sent_by'] = $request->hr_id;
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
            $interview_date = Carbon::parse($applicant->interview_date)->toDayDateTimeString();

            if($request->is_onsite){
                $location = $applicant->job->locationLink->value;
                $message = "Greetings, $name.\n\nYou're scheduled for an interview: \nDate: $interview_date\nPosition: $position.\n\nLocated at $location office.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";

            }else{
                $message = "Greetings, $name.\n\nYou're scheduled for an interview: \nDate: $interview_date\nPosition: $position.\n\nPlease use this link as reference for the interview link: $link.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";
            }
;
            if(env('APP_ENV') != 'local'){
                $client = new Semaphore(config('services.semaphore.api_key'));
                $res = $client->sendSMS($applicant->user->contact_number, $message);
                auditLog($applicant->user->id, "SMS sent for Interview Link");
            }


            auditLog($applicant->user->id, "E-mail sent for Interview Link");
            Mail::to(User::find($tagged_id)->email)
                ->send(
                    new JobApplicationTagged($applicant, 'SEND_INTERVIEW', $tagged_id)
                );

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
            $interview_date = Carbon::parse($applicant->interview_date)->toDayDateTimeString();

            if($request->is_onsite){
                $location = $applicant->job->locationLink->value;
                $message = "Greetings, $name.\n\nYou're scheduled for final interview: \nDate: $interview_date\nPosition: $position.\n\nLocated at $location office.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";

            }else{
                $message = "Greetings, $name.\n\nYou're scheduled for final interview: \nDate: $interview_date\nPosition: $position.\n\nPlease use this link as reference for the interview link: $link.\n\nYou may also check you're registered email ($email) for more information.\nThank you.\EntregoHR";
            }

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
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($applicant, 'JOB_OFFER', $tagged_id)
            );
        }
       

        return response()->json(['data'=>[]], 200);
    }

    public function patch(Request $request, $id)
    {
        $user_job = UserJobApplication::with('user','job')->findOrFail($id);
        $status = $request->status;
        $name = $user_job->user->fullname;
        $job = $user_job->job;
        $tagged_id = $request->hr_id;
        
        $client = new Semaphore(config('services.semaphore.api_key'));

        if($status === UserJobApplication::CANCELLED){

            Mail::to($user_job->user->email)
                ->send(
                    new JobCancelledMail($user_job)
                );

            $user_job->update([
                'cancelled_at'=>now(),
                'cancelled_by'=>$tagged_id,
                'cancelled_notes'=> $request->notes
            ]);

            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - CANCELLED", $user_job);
            
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($user_job, UserJobApplication::CANCELLED, $tagged_id)
            );

        }
        if($request->status === UserJobApplication::REJECTED){
            
            Mail::to($user_job->user->email)
                ->send(
                    new JobRejectedMail($user_job)
                );
            $message = "Hi, $name\n\nWe regret to inform you that we have chosen to move forward with another candidate for the position you applied for. We appreciate your interest in our company and wish you the best in your job search.\n\nThank you,\nEntregoHR";
            $client->sendSMS($user_job->user->contact_number, $message);
            $user_job->update([
                'rejected_at'=>now(),
                'rejected_notes'=>$request->notes,
                'rejected_by'=>$request->hr_id
            ]);

            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - REJECTED", $user_job);
            // $user_job->update([

            // ]);
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($user_job, UserJobApplication::REJECTED, $tagged_id)
            );
        }elseif($request->status === UserJobApplication::APPROVED){
            Mail::to($user_job->user->email)
            ->send(
                new JobApprovedMail($user_job)
            );
            $message = "Greetings, $name\n\nWe're excited to move forward with your application process.\n\nPlease upload the required documents on the Requirements Tab on your profile page.\nEach of your uploaded files will be checked and validated by our Team.\n\nWe will update you after those requirements are accepted..\n\nThank you,\nEntregoHR";
            $client->sendSMS($user_job->user->contact_number, $message);
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - APPROVE", $user_job);
            $user_job->update(['approved_at'=>now()]);
            $user_job->update(['job_offer_accepted_at'=>now()]);
            $user_job->update([
                'approved_notes'=>$request->notes,
                'job_offer_approved_by'=>$request->hr_id

            ]);
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($user_job, UserJobApplication::APPROVED, $tagged_id)
            );

        }

        // Job Offer is accepted
        if($request->status == UserJobApplication::FOR_REQUIREMENTS){
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - FOR REQUIREMENTS", $user_job);
            $user_job->update([
                'job_offer_accepted_at'=>now(),
                'accepted_job_offer_notes'=>$request->notes,
                'job_offer_accepted_by'=>$request->hr_id
            ]);
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($user_job, UserJobApplication::FOR_REQUIREMENTS, $tagged_id)
            );

        }

        if($status == UserJobApplication::DEPLOYED){
            $status = UserJobApplication::DEPLOYED;
            $notes = $request->notes;
            $hr_id = $request->hr_id;
            $request->request->replace(['status' => $status]);
            $message = "Greetings, $name\n\nYou are now deployed as $job->job_title.\n\nThank you,\nEntregoHR" ;
            $client->sendSMS($user_job->user->contact_number, $message);
            auditLog($user_job->user->id, "Job Application Changed Status[$job->job_title] - DEPLOYED", $user_job);
            $user_job->update([
                'deployed_at'=>now(),
                'deployed_notes'=> $notes,
                'deployed_by'=>$hr_id

            ]);
            $user_job->user->cancelJobApplications($id);
            Mail::to(User::find($tagged_id)->email)
            ->send(
                new JobApplicationTagged($user_job, UserJobApplication::DEPLOYED, $tagged_id)
            );

        }

        $user_job->update($request->except('notes_type','notes','hr_id'));
        
    }


    public function viewReport(Request $request)
    {
        $viewer = App::make('dompdf.wrapper'); 
        $user = auth()->user();
        $is_dept_head = $user->role == User::SUB_HR;
        $applicants = $this->generateList($request, true, $is_dept_head= $is_dept_head, $user_id = $user->id);
        // return view('job-applications.report', compact('applicants'));
        $id = Str::uuid();
        $pdf = $viewer->loadView('job-applications.report', compact('applicants'))->setPaper('legal', 'landscape');
        return $pdf->download("REPORT $id.pdf");
    }
    public function viewReportType(Request $request, $type)
    {
        $viewer = App::make('dompdf.wrapper'); 
        $user = auth()->user();
        $is_dept_head = $user->role == User::SUB_HR;
        $applicants = $this->generateList($request, true, $is_dept_head= $is_dept_head, $user_id = $user->id, $type);
        // return view('job-applications.report', compact('applicants'));
        $id = Str::uuid();
        $pdf = $viewer->loadView('job-applications.report', compact('applicants'))->setPaper('legal', 'landscape');
        return $pdf->download("REPORT $id.pdf");
    }

    public function generateList($request, $for_report = false, $is_dept_head = false, $user_id= null, $type=null)
    {
  
        $q = UserJobApplication::with(['user','job.quiz.questions','userQuiz.quiz'=>function($q){
                $q->orderBy('userQuiz.score','desc');
            }])
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
            ->when($is_dept_head, function($q, $value) use ($user_id, $is_dept_head){
                if($value){
                   $q->whereRelation('job','requested_by', $user_id);
                }
            })
            ->when($request->job_id, function($q, $value){
                $q->where('man_power_id', $value);
            })
            ->when($type, function($q, $value){
                if($value === 'in-progress'){
                    return $q->whereIn('status', UserJobApplication::IN_PROGRESS);
                }
                if($value === 'deployed'){
                    return $q->whereIn('status', [UserJobApplication::DEPLOYED]);
                }
                if($value === 'rejected'){
                    return $q->whereIn('status', [UserJobApplication::REJECTED]);
                }

                if($value === 'cancelled'){
                    return $q->whereIn('status', [UserJobApplication::CANCELLED]);
                }
            });
        if($for_report){
            return $q->get();
        }
            return $q->paginate(20)->withQueryString();
            
    }

    public function deployedList($request)
    {
        return UserJobApplication::with(['user','job.quiz.questions','userQuiz.quiz'=>function($q){
            $q->orderBy('userQuiz.score','desc');
        }])
        ->when($request->q, function($q, $value){
            $q
                ->whereRelation('user','email', 'LIKE' , "%$value%")
                ->orWhereRelation('user','first_name', 'LIKE' , "%$value%")
                ->orWhereRelation('user','last_name', 'LIKE' , "%$value%");
        })
        ->when($request->department,function($q, $value){
            $q
            ->whereRelation('job','department', $value);
        })
        ->when($request->job_id, function($q, $value){
            $q->where('man_power_id', $value);
        })
        ->where('status', UserJobApplication::DEPLOYED)
        ->get();
    }

    public function show($id)
    {   
        $application = UserJobApplication::with('user','job')->findOrFail($id);
        $other_jobs = $application->user->jobApplications()->where('id','!=', $id)->with('job')->get();
        return view('job-applications.show', compact('application','other_jobs'));
    }
}