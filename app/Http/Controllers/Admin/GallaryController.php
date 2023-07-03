<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GallaryDetile;
use App\Gallary;
use App\Image;
class GallaryController extends Controller
{ 
    public function index() { 
        $gallary = Gallary::all();
        return view('admin.gallary.index' , compact("gallary"));
    }
    public function create(){
        return view('admin.gallary.create');
    }
    public function store(Request $request) { 
        $data = array(
            "name"=>$request->title,
            "description"=>$request->description,
        );
        Gallary::create($data);
        $lastId=  Gallary::latest('id')->first(); 
        $data = $request->file('file');
        foreach ($data as $files) {
                    $filed = $files->move(public_path('storage/image'));

        $files =$files->getClientOriginalName();
        GallaryDetile::create([
            'filename' => $files,
            "gallary_id"=>$lastId->id       ,
        ]);
        }
    }
    public function edit(Request $request){
        $gallary = Gallary::find($request->id);
        // $gallaryDetail = GallaryDetile::all()->where('gallary_id','=',$request->id);
        // $file_ext = array('png','jpg','jpeg','pdf'); 
        // foreach (File::allFiles(public_path($gallary)) as $file) { 
        // $extension = strtolower($file->getExtension()); 
        //  if(in_array($extension,$file_ext)){ // Check file extension 
        //      $filename = $file->getFilename(); 
        //      $size = $file->getSize(); // Bytes 
        //      $sizeinMB = round($size / (1000 * 1024), 2);// MB 
        //   } ;
        return view('admin.gallary.edit', compact('gallary'));
    }
    public function initPhoto(Request $request){
     $gallaryDetail = GallaryDetile::all()->where('gallary_id','=',$request->id);
     return $gallaryDetail;
    }
}