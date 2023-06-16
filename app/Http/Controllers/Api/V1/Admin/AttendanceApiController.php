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
use App\Attendance;
use Notification;
use App\Notifications\FirebaseNotification;
use DB;

class AttendanceApiController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserResource(User::with(['roles', 'class'])->get());
    }

    public function addAttendance(Request $request){
        $alternate_id = $request->input('student_id');//alternate_id
        $date = $request->input('date');

        $student = User::where('email',$alternate_id)->first(); 
        
        if($student)
            $request->request->add(['real_id'=>$student->id]);
        else
            return response()->json(['status'=>false,'message'=>'Student ID is not exist.','data'=>[]], 401);

        $validated = Validator::make($request->all(),[
            // 'student_id' => 'required|numeric|unique:attendances,student_id,null,id,date,' . $date,
                'real_id' => 'required|numeric|unique:attendances,student_id,null,id,date,' . $date,
                'date' => 'required|date_format:Y-m-d H:i:s',
            ]);

          //  $fcmTokens = $student->firebasetokens;
            $tokenkey = $student->firebasetokens->pluck('firebasekey')->toArray();
        //    return response()->json($tokenkey);
            $title = "Card Scanner Notification";
            $app_name = "Fingerprint Notification";
            $message = "{$student->name} scanned ID Card at " . date_format(date_create($request->input('date')),"H:i A"); 

            Notification::send($student,new FirebaseNotification($message,$title,$tokenkey,$app_name,'0',''));

            //return $fcmTokens;
            // foreach($fcmTokens as $token){
            //     //$scantime = strtotime('09:00');
            //     $tokenkey = $token->firebasekey;
            //     $title = "Attendance Notification";

            //     // $message = "Student Name '{$student->name}' has checked " . (date("H:i:s")<=$scantime?'in':'out') . " at " . date("d/m/Y h:i A"); 
            //     $message = "{$student->name} scanned card at " . date_format(date_create($request->input('date')),"Y-m-d H:i A"); 

            //      Notification::send($student,new FirebaseNotification($message,$message,$tokenkey,$title,'0',''));
            // }

            if($validated->fails()){
                return response()->json(['status'=>false,'message'=>"Date: " . date("d/m/Y h:i A") . " , Student: '{$student->name}' has already been taken attendance.",'data'=>$validated->messages()], 401);
            }

            // Data for insert into attadendance tablle
            $data=[
                'user_id' => 1,
                'student_id'=>$request->input('real_id'), 
                'date' => $request->input('date'),
                'status' => 'Present',
            ];   

       //     return response()->json(Attendance::where('student_id','=',$request->input('real_id'))->whereDate('date',date_format(date_create($request->input('date')),"Y-m-d"))->get());
            
           // if(!Attendance::where('student_id',$request->input('real_id'))->whereDate('date',date_format(date_create($request->input('date')),"Y-m-d"))->exists())
                Attendance::create($data);
            //else{
              //  return response()->json(['status'=>false,'message'=>'No Record to apppend. Its already existing.','data'=>[]],$this->successStatus);
            //}

        return response()->json(['status'=>true,'message'=>'Student Name ' . $student->name . ' is Present.','data'=>$data], $this->successStatus);

   

       // return response()->json(['status'=>false,'message'=>'Unauthorized.','data'=>[]], 401);

    }
    
    public function getMonthAttendance(Request $request){ 
        if(auth()->check() && $request->has('month') && $request->has('year')){

          //  $attendance =  ;

            $data = [
                'present' => Attendance::where('student_id',auth()->user()->id)->whereMonth('date',$request->month)->whereYear('date',$request->year)->orderBy('date')->where('status','Present')->groupBy(DB::raw('DATE(date)'))->get(),
                'excused' => Attendance::where('student_id',auth()->user()->id)->whereMonth('date',$request->month)->whereYear('date',$request->year)->orderBy('date')->where('status','Absent & Excused')->groupBy('date')->get(),
                'unexcused' => Attendance::where('student_id',auth()->user()->id)->whereMonth('date',$request->month)->whereYear('date',$request->year)->orderBy('date')->where('status','Absent & Unexcused')->groupBy('date')->get(),
            ];

            return response()->json(['status'=>true,'data'=>$data],201);
        }

        return response()->json(['status'=>false],401);

    }

    public function getattandancedetail(Request $request){   // Auth
        if(!$request->has('date'))
            $data = ['status'=>false,'message'=>'No Record','data'=>[]];
        else {

            $data = auth()->user()->getattendancedetail($request->date);

        
            $data=['status'=>true,'message'=>'Student Attendance Detail for Student Name:','data'=>$data];

        }    
  
        return response()->json($data, $this->successStatus);

    }
    
    public function getAttendances(Request $request){   // Auth

       // if(!$request->has('student_id'))
       if(!auth()->check())
            $data = ['status'=>false,'message'=>'No Record','data'=>[]];
        else {

            $attendances =  Attendance::with(['students'=> function($query) use($request) {
                 $query->select(['id','email as Alternate ID','name']);
            }])->whereHas('students',function($query) use($request){
                 $query->where('id',auth()->user()->id);
            })->orderBy('date','desc')->paginate(10);

           
            $data=['status'=>true,'message'=>'Student Attendance History for Student Name:','data'=>$attendances];

        }    
        

        return response()->json($data, $this->successStatus);

    }
    
    

}
