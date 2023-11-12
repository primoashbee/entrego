<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PersonalAssessment;
use Spatie\Browsershot\Browsershot;
use App\Models\UserPersonalAssessment;
use Illuminate\Support\Facades\Storage;

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

    public function imgReport($id)
    {
        $data = User::with('assessments')->findOrFail($id)->assessments()->orderBy('id','desc')->first();
        return view('assessment.graph', compact('data'));
    }

    public function generateGraph($id)
    {
        $pathToImage = Storage::disk('public')->path('test-img.png');
        Browsershot::url(route('assessment.img', $id))->save($pathToImage);
        return $pathToImage;
    }
}
