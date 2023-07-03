<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gallary;
use App\GallaryDetile;
class GallaryController extends Controller
{
    public function getGallary(Request $request){
        $data = collect();
        if(empty($request->id)){
        $gallary = Gallary::all();
        foreach($gallary as $key =>$gal){
            $image = GallaryDetile::all()->where('gallary_id','=',$gal->id)->first()->filename;
            $data->push([
                "id"=>$gal->id,
                "title"=>$gal->name,
                "image"=> asset('storage/image' . $image),
                "date"=>$gal->created_at->format('Y-m-d')
            ]);}
        }else{
            $gallary = GallaryDetile::all()->where('gallary_id','=',$request->id);
            foreach($gallary as $key =>$gal){
            $data->push([
                "image"=>asset('storage/image' . $gal->filename),
            ]);
            }
        }
        return response()->json([
            "data"=>$data
        ]);
    }
}