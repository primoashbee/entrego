<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class GeneratePDFController extends Controller
{
    public function index($user_id)
    {
        $user = User::with('workHistory','assessments')->findOrFail($user_id);
        $viewer = App::make('dompdf.wrapper'); 

        $image_src = Storage::disk('public')->path('test-img.png');
        Browsershot::url(route('assessment.img', 2))->save($image_src);
        
        $pdf = $viewer->loadView('templates.pdf.profile', compact('user', 'image_src'));

        
        //Save the pdf
        $path = public_path('');
        $fileName =  $user->uuid. '.' . 'pdf' ;
        $cvFilePath = $path . '/' . $fileName; 
        $pdf->save($cvFilePath);
        $zip = new \ZipArchive();

        $fileName = "$user->fullname.zip";
        $files = User::find(2)->downloadablesPath();
        $files[] = [
                'name'=> $user->fullname . ' - Profile.pdf',
                'path'=>$cvFilePath
            ];
        if(file_exists($fileName)){
            unlink($fileName);
        }
        if ($zip->open(public_path($fileName), \ZipArchive::CREATE)== TRUE)
        {
            foreach ($files as $key => $value){
                $zip->addFile($value['path'], $value['name']);
            }
            $zip->close();
        }
        unlink($cvFilePath);
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);

    }
}
