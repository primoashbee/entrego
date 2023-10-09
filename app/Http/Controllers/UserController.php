<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

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
       auth()->user()->update([
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

       return redirect()->route('profile.edit');
    }

    public function updateUser(UpdateProfileRequest $request, $id)
    {
       User::findOrFail($id)->update([
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
       ]);
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
}
