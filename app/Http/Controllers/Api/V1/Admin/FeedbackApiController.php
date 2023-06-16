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

class FeedbackApiController extends Controller
{
    public $successStatus = 200;

    public function addFeedback(Request $request){

        if($request->file('file')){
        
         $validated=Validator::make($request->all(),[
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required',
            'question' => 'required',
            
         ]);
       
        }else{
            $validated=Validator::make($request->all(),[
                'category' => 'required',
                'question' => 'required',
             ]);
        }

        if($validated->fails()){
            return response()->json(['status'=>false,'message'=>"Invalid Paramter",'data'=>$validated->messages()], 401);
        }

        if ($files = $request->file('file')) {
            $fileName =  "feedback-".time().'.'.$request->file->getClientOriginalExtension();
            $request->file->storeAs('image', $fileName);

        }

        $category = $request->category;
        $question = $request->question;

        $data = array(
            'student_id' => Auth::user()->id,
            'category' => $category,
            'question' => $question,
            'image' => $request->file('file')?$fileName:'',
        );

        $feedback = Feedback::create($data);
    

        return response()->json(['status'=>true,'message'=>'Feedback message has been send to School Admin.','data'=>[]], $this->successStatus);

    }

    public function getFeedbacks(Request $request){

        $data=Feedback::where('student_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);

        return response()->json(['status'=>true,'message'=>'Feedback List','data'=>$data], $this->successStatus);

    }

    public function getFeedbacksDetail(Request $request){
        if(!$request->has('trid'))
            return response()->json([]);

        $data=Feedback::find($request->trid);

        return response()->json(['status'=>true,'message'=>'Feedback Detail','data'=>$data], $this->successStatus);

    }

    

    public function getFeedbackCategory(Request $request){

            $type = DB::select(DB::raw("SHOW COLUMNS FROM feedback WHERE Field = 'category'"))[0]->Type ;
            $data=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
     

        return response()->json(['status'=>true,'message'=>'Feedback Category List','data'=>$data], $this->successStatus);

    }

}
