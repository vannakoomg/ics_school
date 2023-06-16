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
use App\Examschedule;
use App\SchoolClass;
use Notification;
use App\Notifications\FirebaseNotification;
use Auth;


class ExamscheduleApiController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserResource(User::with(['roles', 'class'])->get());
    }
   

    public function getExamList(Request $request){
    
        $class = Auth::user()->class;
        $data = tap(Examschedule::with('course:id,name')->orderBy('date','asc')->orderBy('start_time','asc')
        ->whereHas('class' , function($q){
            $q->where('class_id',Auth::user()->class->id);
            //->where('date','>=', date('Y-m-d'))-
        })->where('date','>=', date('Y-m-d'))->paginate(10))->map(function($examschedule){

            $examschedule->class_id =Auth::user()->class->id;
            $examschedule->class = SchoolClass::find(Auth::user()->class->id);
            return $examschedule;
        });

        return response()->json(['status'=>true,'message'=>'Exam Schedule List for Class ' . $class->name ,'data'=>$data], $this->successStatus);
    }

   

    
    // public function addAttendance(Request $request){
        
    //     if(auth()->attempt(['email' => $request->email, 'password' => $request->password],true)){
    //         $user = auth()->user();

    //         $alternate_id = $request->input('student_id');//alternate_id
    //         $date = $request->input('date');

    //         $student = User::where('email',$alternate_id)->first();

    //    // $student = auth('api')->user()->where('email',$alternate_id)->get();
    //         if($student)
    //             $request->request->add(['real_id'=>$student->id]);
    //         else{
    //             auth()->user()->tokens()->delete();
    //             return response()->json(['status'=>false,'message'=>'Student ID is not exist.','data'=>[]], 401);
    //         }
                
    //     $validated = Validator::make($request->all(),[
    //        // 'student_id' => 'required|numeric|unique:attendances,student_id,null,id,date,' . $date,
    //         'real_id' => 'required|numeric|unique:attendances,student_id,null,id,date,' . $date,
    //         'date' => 'required|date_format:Y-m-d',
    //     ]);

    //     $fcmTokens = $student->firebasetokens;

    //     //return $fcmTokens;
    //     foreach($fcmTokens as $token){
    //         $scantime = strtotime('09:00');
    //         $tokenkey = $token->firebasekey;
    //         $title = "Time Attendance";

    //         $message = "Student Name:{$student->name} check-" . (date("H:i:s")<=$scantime?'in':'out') . " at " . date("d/m/Y h:i A"); 

    //         Notification::send(auth()->user(),new FirebaseNotification($title,$message,$tokenkey,'fingerprint','0',''));
    //     }

    //     if($validated->fails()){
    //         auth()->user()->tokens()->delete();
    //         return response()->json(['status'=>false,'message'=>"Date: {$date} , Student Name: '{$student->name}' has already been taken attendance.",'data'=>$validated->messages()], 401);
    //     }

    //     // $student = User::where('id',$student_id)->get();

    //     // dd($student);
        
    //     // if($student==null)
    //     //     return response()->json(['status'=>false,'message'=>'Unmatch student id'], 401);


    //     $data=[
    //         'user_id' => 0,
    //         'student_id'=>$request->input('real_id'), 
    //         'date' => $request->input('date'),
    //         'status' => 'Present',
    //     ];    

        
        
    //     if(!Attendance::where('student_id',$request->input('student_id'))->where('date',$request->input('date'))->exists())
    //         Attendance::create($data);
    //     else{
    //         auth()->user()->tokens()->delete();
    //         return response()->json(['status'=>false,'message'=>'No Record to apppend. Its already existing.','data'=>[]],$this->successStatus);
    //     }

       

    //     auth()->user()->tokens()->delete();
    //     return response()->json(['status'=>true,'message'=>'Student Name is Present.','data'=>$data], $this->successStatus);

    //     }

    //     return response()->json(['status'=>false,'message'=>'Unauthorized.','data'=>[]], 401);

    // }
    
    
    // public function getAttendances(Request $request){   // Auth

    //     if(!$request->has('student_id'))
    //         $data = ['status'=>false,'message'=>'No Record','data'=>[]];
    //     else {

    //         $attendances =  Attendance::select(['date','student_id','status'])->with(['students'=> function($query) use($request) {
    //              $query->select(['id','email as Alternate ID','name'])->where('email',$request->student_id);
    //         }])->orderBy('date','desc')->limit(30)->get();

           
    //         $data=['status'=>true,'message'=>'Student Attendance for 30 days of Student Name:','data'=>$attendances];

    //     }    
        

    //     return response()->json($data, $this->successStatus);

    // }
    
    

}
