<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Requirement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserRequirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccountStatusChanged;
use function PHPUnit\Framework\isNull;
use App\Http\Requests\StoreUserRequest;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{

    public function index(Request $request) : View
    {   
        $active_users = User::query()
        // ->when(request('query', false), function($q, $query){    
        //     dd($query);
        // })
        ->where('is_archived', false)
        ->whereIn('role', [User::APPLICANT, User::SUB_HR, User::HR])
        ->when($request->q, function($q, $value){
                $q->where('email', 'LIKE' , "%$value%");
                $q->orWhere('first_name', 'LIKE' , "%$value%");
                $q->orWhere('last_name', 'LIKE' , "%$value%");
        })
        ->paginate(20)
        ->withQueryString();
        // ->get();

        

        
        $archived_users = User::query()
        // ->when(request('query', false), function($q, $query){    
        //     dd($query);
        // })
        ->where('is_archived', true)
        ->where('role', User::APPLICANT)
        ->get();
        
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
        $user = User::with(['requirements','archiveLogs.doneBy'=>function($q){
            return $q->orderBy('id','desc');
        }])->findOrFail($id);

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

        auditLog($user->id, 'Updated profile');

        
        if($request->has('company_name')){
            $user->workHistory()->delete();
            foreach($request->company_name as $index=>$value){
                $user->workHistory()->create([
                    'company_name'=>$request->company_name[$index] ?? '',
                    'job_title'=>$request->job_title[$index] ?? '',
                    'start_date'=>$request->start_date[$index] ?? '',
                    'end_date'=>$request->end_date[$index] ?? '' ,
                    'accomplishments'=>$request->accomplishments[$index] ?? '',
                    'employment_type'=>'',
                ]);

            }
            auditLog($user->id, 'Updated work history');

        }

        if($request->has('password') && !isNull($request->password)){
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
            auditLog($user->id, 'Changed Password');
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
            auditLog($user->id, 'Uploaded a CV');

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

                auditLog($user->id, "Uploaded a requirement [$req_name]");

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
        $name = $user->fullname;
        $user->update($fields);

        auditLog(auth()->user()->id, "Updated Profile for $name", $user);

        if($request->has('password') && !isNull($request->password)){
            dump($request->password);
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
            auditLog(auth()->user()->id, "Updated Password for $name", $user);
        }
        return redirect()->route('users.index');
    }

    public function createUser()
    {
        return view('user.create');
    }
    public function storeUser(StoreUserRequest $request)
    {

        $user= User::create([
            'email'=>$request->email,
            'role'=>$request->role,
            'password'=>Hash::make($request->password),
            'uuid'=>strtoupper(Str::uuid()),
            'cv_name'=>'',
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            // 'has_finished_profile'=> true,
        ]);
        $role = $request->role;
        if($request->role == User::SUB_HR){
            $role = 'DEPARTMENT HEAD';
        }
        auditLog(auth()->user()->id, "Created a new user $request->email - $role", $user);

        return redirect()->back();
    }

    public function applicants(Request $request)
    {

        $active_users = User::query()
        ->when($request->q, function($q, $value){    
            $q->orWhere('email', 'LIKE' , "%$value%");
            $q->orWhere('first_name', 'LIKE' , "%$value%");
            $q->orWhere('last_name', 'LIKE' , "%$value%");
        })
        ->where('is_archived', false)
        ->where('role', User::APPLICANT)
        ->paginate(15);


        $archived_users = User::when($request->q, function($q, $value){    
            // $q->where('email', 'LIKE' , "%$value%");
            // $q->orWhere('first_name', 'LIKE' , "%$value%");
            // $q->orWhere('last_name', 'LIKE' , "%$value%");
        })
        ->where('role', User::APPLICANT)
        ->where('is_archived', true)

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

    public function patch(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if($request->archive_status === "ACTIVE"  ){
            
            $user->update([
                'is_archived'=>0,
                'archived_at'=>now()
            ]);

            $user->archiveLogs()->create([
                'status' => 1,
                'done_by'=>auth()->user()->id,
                'notes'=>$request->archive_notes
            ]);


        }
        if($request->archive_status === "ARCHIVED" ){
            $user->update([
                'is_archived'=>1,
                'archived_at'=>now()
            ]);

            $user->archiveLogs()->create([
                'status' => 0,
                'done_by'=>auth()->user()->id,
                'notes'=>$request->archive_notes
            ]);

        }
        Mail::to($user->email)
            ->send(
                new UserAccountStatusChanged($user)
            );
        return redirect()->back();
    }

    public function pdfReport($id)
    {
        $user = User::with(['workHistory','assessments'=>function($q){
                $q->orderBy('id','desc');
            }])->findOrFail($id);
        $assessment = $user->assessments->first()->statsV2();
        $viewer = App::make('dompdf.wrapper'); 
        $pdf = $viewer->loadView('templates.pdf.profile', compact('user','assessment'));

        return view('templates.pdf.profile', compact('user','assessment'));
    }
}
