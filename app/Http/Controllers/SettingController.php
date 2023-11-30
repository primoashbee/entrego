<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobLevel;
use App\Models\Location;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('value','asc')->get();
        $departments = Department::orderBy('value','asc')->get();
        $job_levels = JobLevel::orderBy('value','asc')->get();
        return view('settings.index', compact('locations','departments','job_levels'));
    }

    public function create($type)
    {
        $allowed = ['location','department','job_level'];
        if(!in_array($type, $allowed)){
            return redirect()->route('settings.index');
        }
        $type_label =  ucfirst(str_replace("_", " ", $type)) . 's';
        return view('settings.create', compact('type','type_label'));
    }

    public function store(Request $request, $type)
    {
        $allowed = ['location','department','job_level'];
        if(!in_array($type, $allowed)){
            return redirect()->route('settings.index');
        }
        $base_table = $type . "s";
        $field = ucfirst(str_replace("_", " ", $type));
        $request->validate(
            ['value'=>"required|unique:$base_table,value"],
            ['value.unique'=>"$field already exists"]
        );
        $user = auth()->user();
        $key = str_replace(" ","", $request->value);
        $value = $request->value;
        if($type=='location')
        {
            Location::create([
                'key'=> $key,
                'value'=>$value
            ]);

        }
        if($type=='department')
        {
            Department::create([
                'key'=> $key,
                'value'=>$value
            ]);
        }
        if($type=='job_level')
        {
            
            $x = JobLevel::create([
                'key'=> $key,
                'value'=>$value
            ]);
        }

        // auditLog($user->id, "Created a new $type - $value");

        return redirect()->route('settings.index');
    }

    public function edit($type, $id)
    {
        $model = $this->getModel($type);
        $item = $model->find($id);
        $allowed = ['location','department','job_level'];
        if(!in_array($type, $allowed)){
            return redirect()->route('settings.index');
        }
        $type_label =  ucfirst(str_replace("_", " ", $type)) . 's';
        return view('settings.edit', compact('type','id','item','type_label'));
    }

    public function patch(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $model->find($id)->update($request->except('_token','_method'));
        return redirect()->route('settings.index');
    }

    public function delete(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $model->find($id)->delete();
        return response()->json([], 204);
    }

    private function getModel($type)
    {
        switch($type){
            case 'location':
                $model = Location::query();
                break;
            case 'department':
                $model = Department::query();
                break;
            case 'job_level':
                $model = JobLevel::query();
                break;
        }
        return $model;
    }
}
