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
        $manpower->total = ManPower::whereMonth('created_at', $now->format('m'))->active()->count();
        $manpower->active = ManPower::whereMonth('created_at', $now->format('m'))->active()->count();
        $manpower->variation = ManPower::variation($now);
        $manpower->overview = ManPower::overview($now);

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
        // dd(
        //         User::active()
        //             ->applicant()
        //             ->finishedAssessment()
        //             ->finishedProfile()
        //             ->count()
        //         );
        $applicant->variation = User::variation($now);

        $processing = new stdClass;
        $processing->total = UserJobApplication::
                            // whereMonth('created_at', $now->format('m'))->
                            count();
        $processing->active = UserJobApplication::
                                    // whereMonth('created_at', $now->format('m'))->
                                    active()->count();
        $processing->variation = UserJobApplication::variation($now);

        $deployed = new stdClass;
        $deployed->total = $processing->total;
        $deployed->active = UserJobApplication::
                                // whereMonth('created_at', $now->format('m'))->
                                deployed()->count();
        $deployed->variation = UserJobApplication::variationDeployed($now);
        
        return view('user.dashboard', compact('manpower', 'applicant','processing', 'deployed'));
    }
}
