<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use App\Models\UserJobApplication;
use Illuminate\Http\Request;
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
        $job = ManPower::findOrFail($id);
        $user = auth()->user()->id;

        $application = UserJobApplication::create([
            'man_power_id'=>$id,
            'user_id'=>$user,
            'status'=> UserJobApplication::APPLIED,
            'applied_at'=>now()
        ]);

        Session::flash('message', 'Job application sent! Please wait for our HR to contact you');
        return redirect()->route('job.create', $id);
    }
}
