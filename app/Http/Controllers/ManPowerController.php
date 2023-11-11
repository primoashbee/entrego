<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\ManPower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreManPowerRequest;
use App\Http\Requests\UpdateManPowerRequest;

class ManPowerController extends Controller
{
    public function index()
    {
        $list = ManPower::when(auth()->user()->role === User::SUB_HR, function($q, $value){
            $q->where('requested_by', auth()->user()->id);
        })
        ->paginate(15);

        return view('manpower.index', compact('list'));
    }

    public function create()
    {   
        $job_group = ManPower::JOB_GROUP;
        $experiences = ManPower::EXPERIENCES;
        $departments = ManPower::DEPARTMENT;
        $vacancies = ManPower::VACANCIES;
        $quizzes = Quiz::select('id','name')->orderBy('id','desc')->get();
        return view('manpower.create', compact('job_group', 'experiences', 'departments','vacancies', 'quizzes'));
    }

    public function store(StoreManPowerRequest $request)
    {
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
            'quiz_id'=> $request->quiz_id
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

        return response()->json(compact('res'), $status = 200);
    }

    public function edit($id)
    {
        $job_group = ManPower::JOB_GROUP;
        $experiences = ManPower::EXPERIENCES;
        $departments = ManPower::DEPARTMENT;
        $vacancies = ManPower::VACANCIES;
        $manpower = ManPower::findOrFail($id);
        $quizzes = Quiz::select('id','name')->orderBy('id','desc')->get();

        return view('manpower.edit', compact('manpower','job_group', 'experiences', 'departments','vacancies','quizzes'));
    }

    public function update(UpdateManPowerRequest $request, $id)
    {
        $manpower = ManPower::findOrFail($id);
        $manpower->update(
            $request->all()
        );
        Session::flash("success", "Manpower has been updated.");
        auditLog(auth()->user()->id, "Updated manpower request - $manpower->job_title", $manpower);

        return redirect()->route('manpower.edit', $id);

    }
}
