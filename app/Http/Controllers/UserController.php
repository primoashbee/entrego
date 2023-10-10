<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{

    public function index(Request $request) : View
    {   
        $users = User::when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->paginate(15);
        return view('user.index', compact('users'));
    }

    public function edit() : View
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function editUser($id) : View
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('user.profile', compact('user'));
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

        if($request->hasFile('cv')){
            $file = $request->file('cv');
            $filename = auth()->user()->uuid . "." . $file->getClientOriginalExtension();
    
            Storage::putFileAs(
                'resumes', $file, $filename
            );
            $user->update([
                'has_cv'=>true,
                'cv_name'=>$filename
            ]);
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

        User::findOrFail($id)->update($fields);
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
            'uuid'=>strtoupper(Str::uuid())
            // 'has_finished_profile'=> true,
        ]);
    }

    public function applicants(Request $request)
    {
        $users = User::when(request('query', false), function($q, $query){    
            dd($query);
        })
        ->where('role', User::APPLICANT)
        ->paginate(15);
        return view('user.index', compact('users'));
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
}
