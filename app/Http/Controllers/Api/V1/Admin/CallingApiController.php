<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Gate;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;
use Validator;
use App\Firebasetoken;
use Response;
use App\Dismissal;
use Notification;
use App\Notifications\FirebaseNotification;
use Auth;
use Carbon\Carbon;

class CallingApiController extends Controller
{

    public $successStatus = 200;

    public function addnew(Request $request, $rfidcard){

        if($request->has('action') && $request->action=='yes'){

            $student = User::where('rfidcard',$rfidcard)->first();

//           return response()->json($student->id);
            if(empty($student))
                return response()->json(['status'=>false,'message'=>'Invalid QRCode'],401);

            $dimissal = Dismissal::where('student_id', $student->id)->whereDate('date_time',date('Y-m-d'))->first();

            $student->class_name = $student->class->name;
            $data=[];
            $data['student_info'] = $student;
            $data['Calling'] = $dimissal;

            if(!empty($dimissal) && strtolower($dimissal->status)=='waiting')
                return response()->json(['status'=>false,'message'=>'The Student "' . $student->name . '" is in waiting list.','data'=>$data],$this->successStatus);
            elseif(!empty($dimissal) && strtolower($dimissal->status)=='takeout')
                return response()->json(['status'=>false,'message'=>'The Student "' . $student->name . '" is already takeout.','data'=>$data],$this->successStatus);


            $data1= [
                'student_id' => $student->id,
                'date_time' => Carbon::now(),
                'status' => 'Waiting'
            ];    

            $dimissal=Dismissal::create($data1);
            $data['Calling'] = $dimissal;

            return response()->json(['status'=>true,'message'=>'Successful Scan QRcode.','data'=>$data],$this->successStatus);
        }

        return response()->json(['status'=>false,'message'=>'Missing API'],401);

    }

}