<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\UserRequirement;
use Illuminate\Support\Facades\Storage;

class UserRequirementController extends Controller
{
    public function download($id)
    {

        $logged_in = auth()->user();
        $requirement = UserRequirement::with('user','requirement')->findOrfail($id);

        $target_user = $requirement->user;
        if($logged_in->id == $target_user->id || $logged_in->role != User::APPLICANT){
            $saved_filename = $requirement->storedFileName();
            $filename =  $requirement->outputFileName();
            if(Storage::disk('requirements')->exists("requirements/$saved_filename")){
                return Storage::download("requirements/$saved_filename", $filename, []);
            }

        }
            return abort(403);
    }

    public function index(Request $request)
    {
        $list = UserRequirement::with('user','requirement')
            ->when($request->has('ids'), function($q) use ($request){
                $q->whereIn('id', explode(',',$request->ids));
            })
            ->orderBy(Requirement::select('name')->whereColumn('requirements.id','user_requirements.requirement_id'))
            ->whereNot('status', UserRequirement::MISSING)
            ->get();
        return view('requirements.index', compact('list'));
    }

    public function patch(Request $request, $id)
    {
        $requirement = UserRequirement::with('user.requirements','requirement')->findOrFail($id);
        
        $requirement->update($request->all());
        $status = $request->status;
        $applicant_name = $requirement->user->email;
        $requirement_name = $requirement->requirement->name;
        
        $approved = $requirement->user->requirements()->where('status', UserRequirement::APPROVED)->count();
        // $total = User::with('requirements')->find($requirement->user->id)->requirements()->count();
        $total = Requirement::where('required',true)->count();
        auditLog($requirement->user->id, "[$approved/$total] Requirement [$requirement_name] for $applicant_name is $status");

        if($approved == $total)
        {
            auditLog($requirement->user->id, "Requirements finished $approved/$total");
        }
        
        
    }

  
}
