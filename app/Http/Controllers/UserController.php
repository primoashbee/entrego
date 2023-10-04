<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
    public function update(UpdateProfileRequest $request){
       auth()->user()->update([
        'first_name'=>$request->first_name,
        'middle_name'=>$request->middle_name,
        'last_name'=>$request->last_name,
        'gender'=>$request->gender,
        'birthday'=>$request->birthday,
        'street'=>$request->street,
        'landmark'=>$request->landmark,
        'city'=>$request->city,
        'zip_code'=>$request->zip_code,
        'skills'=>$request->skills,
        'languages'=>$request->languages,
       ]);
       return redirect()->route('profile.edit');
    }
}
