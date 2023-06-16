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
use App\Course;
use App\Elearning;
use Notification;
use App\Notifications\FirebaseNotification;
use Auth;


class ElearningApiController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserResource(User::with(['roles', 'class'])->get());
    }
    

    public function getElearning(Request $request){   // Auth

        if(!$request->has('course_id') || !$request->has('category') )
            return response()->json(['status'=>false,'message'=>'Course ID and Category are Required for this API.','data'=>[]], 401);
 
        // return response()->json(['eee'=>'ee']);

        $courses =  Elearning::with(['course'=> function($q){
            $q->oldest('name');
        }])->whereHas('class' , function($q){
            $q->where('class_id',Auth::user()->class->id);
        })->where('active',1)->where('course_id',$request->course_id)->where('category',$request->category)->oldest('lesson')->paginate(10);

        $data=['status'=>true,'message'=>'Elearning List','data'=>$courses];

        return response()->json($data, $this->successStatus);

    }
    
    

}
