<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\ManPower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreManPowerRequest;
use App\Http\Requests\UpdateManPowerRequest;
use App\Mail\ManPowerRequestChanged;
use App\Mail\ManPowerRequestUpdated;
use App\Models\Department;
use App\Models\JobExperience;
use App\Models\JobLevel;
use App\Models\JobNature;
use App\Models\Location;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\Mail;

class ManPowerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->role == User::ADMINSTRATOR){
            $list = ManPower::withCount(['applications'=> function($q){
                $q->whereStatus(UserJobApplication::DEPLOYED);
            }])
            ->get();
        }
        if($user->role == User::SUB_HR || $user->role == User::HR){
            $list = ManPower::withCount(['applications'=> function($q){
                $q->whereStatus(UserJobApplication::DEPLOYED);
            }])
            ->where('requested_by', $user->id)
            ->get();
        }

        // ->paginate(15);

        return view('manpower.index', compact('list'));
    }

    public function create()
    {   
        $job_group = ManPower::JOB_GROUP;
        $vacancies = ManPower::VACANCIES;

        // $departments = ManPower::DEPARTMENT;
        $departments = Department::select('key','value')->orderBy('value','desc')->get();
        $locations = Location::select('key','value')->orderBy('value','desc')->get();
        $levels = JobLevel::select('key','value')->orderBy('value','desc')->get();
        $quizzes = Quiz::select('id','name')->orderBy('id','desc')->get();
        $job_natures = JobNature::select('key','value')->orderBy('id','desc')->get();
        $experiences = JobExperience::select('key','value')->orderBy('id','desc')->get();
        return view('manpower.create', compact('job_group', 'experiences', 'departments','vacancies', 'quizzes','locations','levels','job_natures','experiences'));
    }

    public function store(StoreManPowerRequest $request)
    {
        if($request->has('has_sjt') && $request->has_sjt == 'on'){
            $request->merge(['has_sjt'=>true]);
        }else{
            
            $request->request->add(['has_sjt'=>false]);
        }
        $id = ManPower::create([
            'requested_by'=> auth()->user()->id,
            'job_title'=> $request->job_title,
            'job_group'=> $request->job_group,
            'description'=> $request->description,
            'responsibilities'=> $request->responsibilities,
            'qualifications'=> $request->qualifications,
            'benefits'=> $request->benefits,
            'vacancies'=> $request->vacancies,
            'job_nature'=> $request->job_nature,
            'location'=> $request->location,
            'location'=> $request->location,
            'expires_at'=> $request->expires_at,
            'required_experience'=> $request->required_experience,
            'department'=> $request->department,
            'quiz_id'=> $request->quiz_id,
            'job_level'=>$request->job_level,
            'has_sjt'=> $request->has_sjt
        ])->id;


        

        auditLog(auth()->user()->id, "Request a new manpower - $request->job_title", ManPower::find($id));
        Session::flash("success", "Manpower request has been submitted. Please wait for the approval");
        return redirect()->route('manpower.index');
    }


    public function delete($id)
    {
        $manpower = ManPower::find($id);
        $manpower->delete();
        auditLog(auth()->user()->id, "Manpower request deleted - $manpower->job_title", ManPower::find($id));

        return response()->json([], $status = 200);
    }

    public function patch(Request $request, $id)
    {
        $manpower = ManPower::find($id);
        $res = $manpower->update($request->all());

        $status = $request->active == 1 ? "turned ON" : "turned OFF";
        auditLog(auth()->user()->id, "Manpower request[$manpower->job_title] $status", $manpower);
        Mail::to($manpower->requestor->email)
            ->send(
                new ManPowerRequestChanged($manpower)
            );
        return response()->json(compact('res'), $status = 200);
    }

    public function edit($id)
    {
        $job_group = ManPower::JOB_GROUP;
        $vacancies = ManPower::VACANCIES;
        $manpower = ManPower::with(['notes'=>function($q){ $q->orderBy('id','desc');}])->findOrFail($id);

        $departments = Department::select('key','value')->orderBy('value','desc')->get();
        $locations = Location::select('key','value')->orderBy('value','desc')->get();
        $levels = JobLevel::select('key','value')->orderBy('value','desc')->get();
        $quizzes = Quiz::select('id','name')->orderBy('id','desc')->get();
        $job_natures = JobNature::select('key','value')->orderBy('id','desc')->get();
        $experiences = JobExperience::select('key','value')->orderBy('id','desc')->get();
        // dd($manpower->job_nature);
        return view('manpower.edit', compact('manpower','job_group', 'experiences', 'departments','vacancies', 'quizzes','locations','levels','job_natures','experiences'));

    }

    public function update(UpdateManPowerRequest $request, $id)
    {
        $manpower = ManPower::findOrFail($id);

        if($request->has('has_sjt') && $request->has_sjt == 'on'){
            $request->merge(['has_sjt'=>1]);
        }else{
            
            $request->request->add(['has_sjt'=>0]);
        }
        $manpower->update(
            $request->all()
        );
        $user = auth()->user()->full_name;
        $changes = $manpower->getChanges();
        if(count($changes)){
            $fields = "$user made changes in ";
            foreach($changes as $key=>$change){
                if($key != 'updated_at'){
                    $fields.= "$key = $change, ";
                }
            }
            $fields = rtrim($fields,", ") . ".";

            Session::flash("success", "Manpower has been updated.");
            $note = "Updated manpower request - $manpower->job_title. $fields";

            Mail::to($manpower->requestor->email)
            ->send(
                new ManPowerRequestUpdated($manpower, $note)
            );
            auditLog(auth()->user()->id, $note , $manpower);
            $manpower->notes()->create(['done_by'=>auth()->user()->id,'notes'=>$note]);
        }
       

        return redirect()->route('manpower.edit', $id);

    }

    public function statusList($id)
    {
        return response()->json(['data'=>ManPower::with('applications.user')->findOrFail($id)], 200);
    }
}
