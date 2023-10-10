<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PersonalAssessment;
use App\Models\UserPersonalAssessment;

class PersonalAssementController extends Controller
{
    //show exam
    public function view()
    {
        $questions = PersonalAssessment::orderBy('position','asc')->limit(15)->get()->toArray();
        return view('assessment.create', compact('questions'));
    }

    public function index()
    {   

        if(auth()->user()->role == User::ADMINSTRATOR){
            $list = UserPersonalAssessment::with('user')
                ->distinct()
                ->select('user_id','created_at','extraversion_percentage','agreeableness_percentage','conscientiousness_percentage','neuroticism_percentage','openness_percentage','batch_id')
                ->get();
        }else{
            $list = UserPersonalAssessment::with('user')
                ->distinct()
                ->select('user_id','created_at','extraversion_percentage','agreeableness_percentage','conscientiousness_percentage','neuroticism_percentage','openness_percentage','batch_id')
                ->where('user_id', auth()->user()->id)
                ->get();
        }

        return view('assessment.index', compact('list'));
    }

    public function show($batch_id)
    {
        $data = UserPersonalAssessment::with('question')
            ->where('batch_id',$batch_id)
            ->get();
        return view('assessment.show', compact('data'));
    }
}
