<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Requirement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserRequirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{

    public function index(Request $request) : View
    {   
        $active_users = User::query()
        ->when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->where('is_archived', false)
        ->where('role', User::APPLICANT)
        ->paginate(15);

        
        $archived_users = User::query()
        ->when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->where('is_archived', true)
        ->where('role', User::APPLICANT)
        ->paginate(15);
        
        return view('user.index', compact('active_users','archived_users'));
        return view('user.index', compact('active_users','archived_users'));
    }

    public function edit() : View
    {
        $user = auth()->user()->load('workHistory');
        $requirements = $this->syncRequirements();
        return view('user.profile', compact('user','requirements'));
    }

    public function editUser($id) : View
    {
        $user = User::with('requirements')->findOrFail($id);
        $requirements = $user->requirements;
        // dd($user);
        return view('user.profile', compact('user','requirements'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user  = auth()->user();
        
        $user->update([
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'gender'=>$request->gender,
            'birthday'=>$request->birthday,
            'street'=>$request->street,
            'landmark'=>$request->landmark,
            'contact_number'=>$request->contact_number,
            'barangay'=>$request->barangay,
            'city'=>$request->city,
            'zip_code'=>$request->zip_code,
            'skills'=>$request->skills,
            'languages'=>$request->languages,
            'has_finished_profile'=>true
        ]);
        
        if($request->has('company_name')){
            $user->workHistory()->delete();
            foreach($request->company_name as $index=>$value){
                $user->workHistory()->create([
                    'company_name'=>$request->company_name[$index],
                    'job_title'=>$request->job_title[$index],
                    'start_date'=>$request->start_date[$index],
                    'end_date'=>$request->end_date[$index],
                    'accomplishments'=>$request->accomplishments[$index],
                    'employment_type'=>'',
                ]);

            }
        }

        if($request->has('password')){
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
        }
        if($request->hasFile('cv')){
            $file = $request->file('cv');
            $filename = $user->uuid . "." . $file->getClientOriginalExtension();
    
            Storage::putFileAs(
                'resumes', $file, $filename
            );
            $user->update([
                'has_cv'=>true,
                'cv_name'=>$filename
            ]);
        }

        if($request->hasFile('requirement')){
            foreach($request->file('requirement') as $id => $file){
                $user_req = UserRequirement::find($id);

                $req_name = $user_req->requirement->name;
                $ext = $file->getClientOriginalExtension();
                $filename = "$user->uuid-$req_name.$ext";
                Storage::putFileAs(
                    'requirements', $file, $filename
                );

                UserRequirement::find($id)
                ->update([
                    'status'=> UserRequirement::PENDING_FOR_APPROVAL,
                    'file_name'=>$filename,
                    'extension' => $ext
                ]);
            }

        }
       return redirect()->route('profile.edit');
    }

    public function updateUser(UpdateProfileRequest $request, $id)
    {
    
        
        $fields = [
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'gender'=>$request->gender,
            'birthday'=>$request->birthday,
            'street'=>$request->street,
            'landmark'=>$request->landmark,
            'contact_number'=>$request->contact_number,
            'barangay'=>$request->barangay,
            'city'=>$request->city,
            'zip_code'=>$request->zip_code,
            'skills'=>$request->skills,
            'languages'=>$request->languages,
            'role'=>$request->role,
            'has_finished_profile'=>true
        ];

        if(auth()->user()->role !== User::ADMINSTRATOR){
            unset($fields['role']);
        }
        
        $user = User::findOrFail($id); 
        $user->update($fields);
        if($request->has('password')){
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
        }
        return redirect()->route('users.index');
    }

    public function createUser()
    {
        return view('user.create');
    }
    public function storeUser(StoreUserRequest $request)
    {
        User::create([
            'email'=>$request->email,
            'role'=>$request->role,
            'password'=>Hash::make($request->password),
            'uuid'=>strtoupper(Str::uuid()),
            'cv_name'=>''
            // 'has_finished_profile'=> true,
        ]);
        return redirect()->back();
    }

    public function applicants(Request $request)
    {

        $active_users = User::query()
        ->when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->where('is_archived', false)
        ->where('role', User::APPLICANT)
        ->paginate(15);


        $archived_users = User::query()
        ->when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->where('is_archived', true)
        ->where('role', User::APPLICANT)
        ->paginate(15);
        
        return view('user.index', compact('active_users','archived_users'));
    }


    public function downloadCV($id)
    {
        $logged_in = auth()->user();
        $target_user = User::findOrFail($id);
        if($logged_in->id == $id){
            $saved_filename = $target_user->cv_name;
            $ext = explode(".",$saved_filename)[count(explode(".",$saved_filename)) - 1];

            
           
            $filename = $target_user->fullname . '.' . $ext;
            if(Storage::disk('resumes')->exists("resumes/$saved_filename")){
                return Storage::download("resumes/$saved_filename", $filename, []);
            }

        }

        if($logged_in->role != User::APPLICANT){
            return abort(403);
        }
    }

    public function syncRequirements()
    {
        $list = Requirement::select('id')->get();
        $user = auth()->user();
        $inserts = [];

        foreach($list as $item){
            if($user->requirements()->where('requirement_id',$item->id)->count() == 0)
            {
                $inserts[] = [
                    'requirement_id' => $item->id,
                    'user_id' => $user->id,
                    'status'=> UserRequirement::MISSING
                ];
            }
        }

        if(count($inserts)){
            UserRequirement::insert($inserts);
            return $user->requirements->load('requirement');
        }
        return $user->requirements->load('requirement');

    }
}
