<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use App\Models\User;
use App\Models\UserJobApplication;
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

        $manpower = new stdClass;
        // $manpower->total = ManPower::whereMonth('created_at', $now->format('m'))->active()->count();
        // $manpower->active = ManPower::whereMonth('created_at', $now->format('m'))->active()->count();
        $manpower->total = ManPower::count();
        $manpower->active = ManPower::active()->count();
        $manpower->variation = ManPower::variation($now);
        $manpower->overview = ManPower::overview();
        $manpower->list = ManPower::orderBy('id', 'desc')->get();

        $applicant = new stdClass;
        $applicant->total  = User::active()
                            ->whereRole(User::APPLICANT)
                            ->count();
        $applicant->active = User::active()
                                    ->applicant()
                                    // ->whereMonth('created_at', $now->format('m'))
                                    ->finishedAssessment()
                                    ->finishedProfile()
                                    ->count();
        $applicant->list = User::active()
                                ->applicant()
                                ->finishedAssessment()
                                ->finishedProfile()
                                ->get();
                                    
        // dd(
        //         User::active()
        //             ->applicant()
        //             ->finishedAssessment()
        //             ->finishedProfile()
        //             ->count()
        //         );
        $applicant->variation = User::variation($now);

        $processing = new stdClass;
        $processing->total = UserJobApplication::count();
                            // whereMonth('created_at', $now->format('m'))->
                            
        $processing->active = UserJobApplication::active()->count();
                                    // whereMonth('created_at', $now->format('m'))->
                                    
        $processing->variation = UserJobApplication::variation($now);
        $processing->list      = UserJobApplication::with('user','job')->orderBy('id','desc')->get();

        $deployed = new stdClass;
        $deployed->total = ManPower::totalManPower();
        $deployed->active = UserJobApplication::
                                // whereMonth('created_at', $now->format('m'))->
                                deployed()->count();
        $deployed->variation = UserJobApplication::variationDeployed($now);
        $deployed->list = UserJobApplication::deployed()
                                    ->orderBy('id','desc')
                                    ->get();
        
        return view('user.dashboard', compact('manpower', 'applicant','processing', 'deployed'));
    }
}
