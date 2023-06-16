<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Feedback;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Homework;
use App\HomeworkResult;
use App\HomeworkAttachment;
use App\HomeworkResultAttachment;

class HomeworkApiController extends Controller
{
    public $successStatus = 200;

    public function assignment_detail(Request $request){
        if($request->homeworkid>0){
            $homework_result = Homework::with(['attachments'])->with(['homeworkresult' => function($q){
                $q->with(['attachments'])->where('student_id',auth()->user()->id);
            }])->find($request->homeworkid);

            return response()->json($homework_result);

        }   
        return response()->json(['status'=>false,'message'=>'Invalid','data'=>[]], 401); 
    }


    public function student_remove_attachment(Request $request){
        if($request->attachment_id){

            // $homework_attachment = HomeworkResult::with(['attachments' => function($q) use($request){
            //     $q->where('homework_result_attachments.id',$request->attachment_id);
            // }])->where('student_id', auth()->user()->id)->first();
            $homework_attachment = HomeworkResultAttachment::whereHas('homeworkresult',function($q){
                $q->where('student_id',auth()->user()->id);
            })->find($request->attachment_id);
            
          //  return response()->json($homework_attachment);

            //$homework_attachment=$homework_attachment->attachments->first();
            
            if($homework_attachment){   
                
            
                if(Storage::exists($homework_attachment->path))
                        Storage::delete($homework_attachment->path);

                $homework_attachment->delete();

                return response()->json(['status'=>true,'message'=>'Successful Remove Attachment.']);
            }

        }

        return response()->json(['status'=>false,'message'=>'Invalid','data'=>[]], 401);
    }

    public function student_add_attachment(Request $request){
        if($request->file('file')){    
            //$homework = Homework::find($request->hwid); 
            
            $student_id = auth()->user()->id;

            // return response()->json($student_id);

            //$title = $homework->name . '(' . date('d-m-Y') . ' at ' . date('h:i a') . ')';

          
            // if($homework->homeworkresult()->where('student_id', $student_id)->count()==0){
            //     $data = new HomeworkResult(['user_id'=>0,'homework_id'=>$homework->id,'student_id'=> $student_id]);
            //     $hmresult = $homework->homeworkresult()->save($data);  //'turnedin'=>0
            // }else{
            //     $hmresult = $homework->homeworkresult()->where('student_id', $student_id)->first();
            // }

           // return response()->json($hmresult->attachments);
            $homework_result = HomeworkResult::find($request->resultid);
            if(empty($homework_result))
                 return response()->json(['status'=>false,'message'=>'Invalid Assignment','data'=>[]], 401);
            //$fileName =  $title . '.' . $request->file->getClientOriginalExtension();
            $temp=$request->file->getClientOriginalName();
            $fileName = date('Ymd') . '-' . $temp;

            $path=$request->file->storeAs('docs', $fileName);
            $data = new HomeworkResultAttachment([
                'filename' => pathinfo($temp)['filename'],
                'path' => $path,
            ]);
        
            $homework_result->attachments()->save($data);

            return response()->json(['status'=>true,'message'=>'Successful Upload','data'=>$homework_result->attachments], $this->successStatus); 
        }
        return response()->json(['status'=>false,'message'=>'Invalid','data'=>[]], 401); 
        
    }

    public function assignment_list(Request $request){

        $student_id = auth()->user()->id;
        // $class_id = User::whereHas('class', function($q) use($student_id){
        //         $q->where('class_id',$);
        // })->get();
        $class_id = auth()->user()->class->id;
        
        // $homework = Homework::find(65);
        // $student_ids = $homework->class->classUsers->pluck('id');

        // return response()->json($student_ids);

        $data =[
            'assigned' => Homework::whereHas('class', function($q) use($class_id){
                                $q->where('class_id',$class_id);
                        })
                        ->where('submitted',1)->whereDate('due_date','>=',date('Y-m-d'))
                        ->whereHas('homeworkresult', function($q) use($student_id){
                                $q->where('student_id',$student_id)->where('turnedin',0);
                        })->get(),
            'missing' => Homework::whereHas('class', function($q) use($class_id){
                                $q->where('class_id',$class_id);
                        })
                        ->where('submitted',1)->whereDate('due_date','<',date('Y-m-d'))
                        ->whereHas('homeworkresult', function($q) use($student_id){
                                $q->where('student_id',$student_id)->where('turnedin',0);
                        })->get(),
            'done' => Homework::whereHas('class', function($q) use($class_id){
                            $q->where('class_id',$class_id);
                    })
                    // ->where('submitted',1)->whereDate('due_date','<',date('Y-m-d'))
                    ->whereHas('homeworkresult', function($q) use($student_id){
                            $q->where('student_id',$student_id)->where('turnedin',1);
                    })->get(),            
    ];

        return response()->json($data);
    }

    public function student_submit_assignment(Request $request){
        if($request->resultid>0){
            //$homework = Homework::find($request->hwid); 
            $student_id = auth()->user()->id;
            $homework_result = HomeworkResult::find($request->resultid);

            // if($homework->homeworkresult()->where('student_id', $student_id)->count()==0){
            //     $data = new HomeworkResult(['user_id'=>0,'homework_id'=>$homework->id,'student_id'=> $student_id,'turnedin'=>1]);
            //     $hmresult = $homework->homeworkresult()->save($data);
            // }else{
            //     $hmresult = $homework->homeworkresult()->where('student_id', $student_id)->first();
            //     $hmresult->update(['remark'=>$request->remark,'turnedindate'=>date('Y-m-d H:i'),'turnedin'=>1]);

            // }

            if(empty($homework_result))
                return response()->json(['status'=>false,'message'=>'Invalid Assignment','data'=>[]], 401); 
            
            $homework_result->update(['remark'=>$request->remark,'turnedindate'=>date('Y-m-d H:i'),'turnedin'=>1]);

            return response()->json(['status'=>true,'message'=>'Your work is Turned-In.','data'=>[]], $this->successStatus);
        }
        return response()->json(['status'=>false,'message'=>'Invalid','data'=>[]], 401); 
    }

    // public function getFeedbacks(Request $request){

    //     $data=Feedback::where('student_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);

    //     return response()->json(['status'=>true,'message'=>'Feedback List','data'=>$data], $this->successStatus);

    // }

    // public function getFeedbacksDetail(Request $request){
    //     if(!$request->has('trid'))
    //         return response()->json([]);

    //     $data=Feedback::find($request->trid);

    //     return response()->json(['status'=>true,'message'=>'Feedback Detail','data'=>$data], $this->successStatus);

    // }

    

    // public function getFeedbackCategory(Request $request){

    //         $type = DB::select(DB::raw("SHOW COLUMNS FROM feedback WHERE Field = 'category'"))[0]->Type ;
    //         $data=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
     

    //     return response()->json(['status'=>true,'message'=>'Feedback Category List','data'=>$data], $this->successStatus);

    // }

}
