<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Feedback;
use Carbon\Carbon;
use App\User;
use App\Notifications\FirebaseNotification;
use Notification;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    
    public function index(Request $request){

     //   dd(Feedback::latest()->toSql());

        if($request->chk_show=='on')
            $feedbacks = Feedback::latest()->get();
        else
            $feedbacks = Feedback::where('reply','0')->latest()->get();

        // dd($feedbacks);    
        return view('admin.feedback.index',compact('feedbacks'));
    }

    public function show(Feedback $feedback){

        return view('admin.feedback.show',compact('feedback'));
    }

    public function update(Feedback $feedback, Request $request){
        if($request->has('answer')){

            $data= [
                'reply'=>1,
                'reply_by' => Auth::user()->id,
                'replied_at' => Carbon::now(),
                'answer' => $request->answer,
            ];

            $feedback->update($data);

            $firebasetokens = User::with('firebasetokens')->find($feedback->student_id);
           // dd($);
          
           // foreach($firebasetokens->firebasetokens as $firebasetoken){
           
                $fcmTokens = $firebasetokens->firebasetokens()->pluck('firebasekey')->toArray();
                $title = 'Q: ' . Str::limit($feedback->question, 32 , '...') . "\nA: " . Str::limit($feedback->answer, 32 , '...');
                $message = $feedback->answer; 
                
                Notification::send($firebasetokens,new FirebaseNotification($title,$message,$fcmTokens,'ICS Feedback',$feedback->id,$feedback->image));
        
                // $jsonArray = json_decode($usercontroller->isSuccessPush($token,$title,$description),true);
           // }

            return redirect()->route('admin.feedback.show',$feedback->id)->withSuccess('The Feedback has been reply.');

        }
        return redirect()->back();
    }

    public function addFeedback(Request $request){

        if($request->file('file')){
         request()->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

      }

        if ($files = $request->file('file')) {
            $fileName =  "feedback-".time().'.'.$request->file->getClientOriginalExtension();
            $request->file->storeAs('image', $fileName);

            $data = array(
                'student_id' => $student_id,
                'category' => $category,
                'question' => $question,
                'image' => $fileName,
            );

            $feed = Feedback::create($data);
            

            return Response()->json([
                "success" => true, 'edit_link' => route('admin.announcement.edit',$announcement->id)
            ], Response::HTTP_OK);

        }
    }

}
