<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Model;

class SettingApiController extends Controller
{

   public function getSetting(Request $request,$setting)
   {
      // abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       if(!empty($setting)){

         if($setting=='version')
            $value = Settings::where('name',$setting)->first();
         else if($setting=='homeslide')
            $value = ['data'=>Settings::where('name',$setting)->orderBy('value')->get()];

         return response()->json($value,201);
       }
       return response()->json(['status'=>false],401);
   }

   	
	   
   public function getDateTime(){

      $data= [
         'status'=>true,
         'data' => [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
         ]
      ];
      return response()->json($data);
   }

}
