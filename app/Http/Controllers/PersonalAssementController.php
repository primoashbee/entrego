<?php

namespace App\Http\Controllers;

use App\Models\PersonalAssessment;
use Illuminate\Http\Request;

class PersonalAssementController extends Controller
{
    public function view()
    {
        $questions = PersonalAssessment::orderBy('position','asc')->limit(3)->get()->toArray();
        return view('assessment.index', compact('questions'));
    }
}
