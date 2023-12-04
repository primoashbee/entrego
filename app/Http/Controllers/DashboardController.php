<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use App\Models\User;
use App\Models\UserJobApplication;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;
use stdClass;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == User::APPLICANT){
            return redirect()->route('profile.edit');
        }
        $now = now();

        if(auth()->user()->role == User::ADMINSTRATOR){
            $manpower = new stdClass;

            $manpower->total = ManPower::count();
            $manpower->active = ManPower::active()->count();
            $manpower->variation = ManPower::variation($now);
            $manpower->overview = ManPower::overview();
            $manpower->list = ManPower::orderBy('id', 'desc')->get();
    
            $applicant = new stdClass;
            $applicant->total  = User::where('is_archived', false)
                                ->whereRole(User::APPLICANT)
                                ->count();

            $applicant->active = User::whereHas('jobApplications')
                                        // ->where('is_archived', false)
                                        // ->where('role', User::APPLICANT)
                                        // ->where('has_finished_profile', true)
                                        // ->where('has_finished_asessment', true)
                                        // ->whereMonth('created_at', $now->format('m'))
                                        // ->finishedAssessment()
                                        // ->finishedProfile()
                                        ->count();
            // $applicant->list = User::active()
            $applicant->list = User::where('is_archived', false)
                                    ->where('role', User::APPLICANT)
                                    ->where('has_finished_profile', true)
                                    ->where('has_finished_asessment', true)
                                    ->get();
            $applicant->variation = User::variation($now);
    
            $processing = new stdClass;
            $processing->total = UserJobApplication::whereNot('status', UserJobApplication::CANCELLED)->count();
                                
            $processing->active = UserJobApplication::active()->count();
                                        
            $processing->variation = UserJobApplication::variation($now);
            $processing->list      = UserJobApplication::with('user','job')->whereNot('status', UserJobApplication::CANCELLED)->orderBy('id','desc')->get();
    
            $deployed = new stdClass;
            $deployed->total = ManPower::totalManPower();
            $deployed->active = UserJobApplication::deployed()->count();
            $deployed->variation = UserJobApplication::variationDeployed($now);
            $deployed->list = UserJobApplication::deployed()
                                        ->orderBy('id','desc')
                                        ->get();

            $graph = ManPower::graphDetails(now()->subYear(), now());
            return view('user.dashboard', compact('manpower', 'applicant','processing', 'deployed', 'graph'));

        }
   

        $manpower = new stdClass;
        $manpower->overview = ManPower::overview(auth()->user()->id);
        $deployed = new stdClass;
        $deployed->total = ManPower::totalManPower();
        $deployed->active = UserJobApplication::deployed()->count();
        $deployed->variation = UserJobApplication::variationDeployed($now);
        $deployed->list = UserJobApplication::deployed()
                                    ->orderBy('id','desc')
                                    ->get();
        return view('user.dashboard', compact('manpower','deployed'));

        
        
        
    }
}
