<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gallarys;
use App\Image;
class GallaryController extends Controller
{
    public function index(){
        $folder = Gallarys::all();
        return view('admin.gallary.index',compact('folder'));
    }
    public function create(){
        return view('admin.gallary.create');
    }
    public function store(Request $request)
    {
      $this->validate($request, [
         'title' => 'required|string|max:255',
     ]);
     $data =array(
        'title'=>$request->title
     );
    Gallarys::create($data);
     return $request->images;
     foreach ($request->file('images') as $imagefile) {
     $path = $imagefile->store('/images/resource', ['disk' =>   'my_files']);
     $image->image = $path;
     $image->folder_id = $image->id;
     $dota =array(

        'image'=>$image->image,
        'folder'=>$image->folder_id
     );
     return $image->image;
     Image::create($dota);
   }}
}