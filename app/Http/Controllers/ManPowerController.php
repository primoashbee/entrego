<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManPowerRequest;
use App\Http\Requests\UpdateManPowerRequest;
use App\Models\ManPower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManPowerController extends Controller
{
    public function index()
    {
        $list = ManPower::when(auth()->user()->role === User::SUB_HR, function($q, $value){
            $q->where('user_id', auth()->user()->id);
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
        return view('manpower.create', compact('job_group', 'experiences', 'departments','vacancies'));
    }

    public function store(StoreManPowerRequest $request)
    {
        ManPower::create([
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
            'department'=> $request->department
        ]);

        Session::flash("success", "Manpower request has been submitted. Please wait for the approval");
        return redirect()->route('manpower.index');
    }


    public function delete($id)
    {
        ManPower::find($id)->delete();
        return response()->json([], $status = 200);
    }

    public function patch(Request $request, $id)
    {
        $res = ManPower::find($id)->update($request->all());
        return response()->json(compact('res'), $status = 200);
    }

    public function edit($id)
    {
        $job_group = ManPower::JOB_GROUP;
        $experiences = ManPower::EXPERIENCES;
        $departments = ManPower::DEPARTMENT;
        $vacancies = ManPower::VACANCIES;
        $manpower = ManPower::findOrFail($id);

        return view('manpower.edit', compact('manpower','job_group', 'experiences', 'departments','vacancies'));
    }

    public function update(UpdateManPowerRequest $request, $id)
    {
        $manpower = ManPower::findOrFail($id);
        $manpower->update(
            $request->all()
        );

        Session::flash("success", "Manpower has been updated.");

        return redirect()->route('manpower.edit', $id);

    }
}
