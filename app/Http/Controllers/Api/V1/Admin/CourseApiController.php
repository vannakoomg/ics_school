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


class CourseApiController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserResource(User::with(['roles', 'class'])->get());
    }
    

    public function getCourses(Request $request){   // Auth

        $courses =  Course::oldest('name')->whereHas('elearnings', function($q){
            $q->whereHas('class' , function($q){
                $q->where('class_id',Auth::user()->class->id);
            });
        })->get();

        $data=['status'=>true,'message'=>'Course List','data'=>$courses];

        return response()->json($data, $this->successStatus);

    }
    
    

}
