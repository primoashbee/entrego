<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Svg\Tag\Rect;

class TutsController extends Controller
{
    public function index(Request $request)
    {
        $tutorials = Tutorial::where('archived', 0)->get(); 
        $name = 'AShbee Morgado';

        return view('tuts.index' , compact('tutorials','name'));
    }

    public function store(Request $request) 
    {
        Tutorial::create([
            'gusto'=>$request->gusto
        ]);
        
        return redirect()->route('tuts.create');
    }

    public function delete(Request $request, $id)
    {
        Tutorial::find($id)->delete();
        return redirect()->route('tuts.create');
    }


    public function patch(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        
        Tutorial::find($id)->update($data);
        return redirect()->route('tuts.create');

    }


}
