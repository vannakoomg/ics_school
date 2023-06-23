<?php

namespace App\Http\Controllers\Admin;

use App\SchoolClass;
use App\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use Notification;
use App\Notifications\FirebaseNotification;
use App\Firebasetoken;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request){
        
        if($request->chk_show=='on')
            $announcements = Announcement::orderBy('created_at','desc')->get();
         else
            $announcements = Announcement::where('send','0')->orderBy('created_at','desc')->get();
            // $feedbacks = Feedback::where('reply','0')->orderBy('created_at','desc')->get();


        return view('admin.announcement.index', compact('announcements'));
    }

    public function show(Announcement $announcement){
        $classes = SchoolClass::all();
        return view('admin.announcement.show',compact('announcement','classes'));
    }

    public function create(){
        $classes = SchoolClass::all();

        return view('admin.announcement.create', compact('classes'));
    }


    public function edit(Announcement $announcement){
        $classes = SchoolClass::all();

        return view('admin.announcement.edit', compact('classes','announcement'));
    }

    public function store(Request $request){

       // dd($request->all());
         request()->validate([
            //'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'txt_body_hidden' => 'required'
         ]);

    

        if ($files = $request->file('imgupload')) {
            $fileName =  "image-".time().'.'.$request->imgupload->getClientOriginalExtension();
            $request->imgupload->storeAs('image', $fileName);
        }else{
            $fileName = 'no-image.png';
            }
            $data = array(
                'user_id' => auth()->user()->id,
                'title' => $request->input('txt_title'),
                'body' => $request->input('txt_body_hidden'),
                'thumbnail' => $fileName,
                'send' => ($request->save_send=='send')?1:0,
            );
            $announcement = Announcement::create($data);
            $announcement->classes()->sync($request->input('txt_class', []));

            // if(!$request->has('txt_class', [])){
            if($request->save_send=='send'){

                $fcmTokens = Firebasetoken::pluck('firebasekey')->toArray();
                $title = $request->input('txt_title');
                $message = $request->input('txt_body_hidden'); 

                Notification::send(Auth()->user(),new FirebaseNotification($title,$message,$fcmTokens,'ICS News',$announcement->id)); //$announcement->thumbnail

                // $firebasetokens = Firebasetoken::all();

                // foreach($firebasetokens as $firebasetoken){
                    
                //     $fcmTokens = $firebasetoken->firebasekey;
                //     $title = $request->input('txt_title');
                //     $message = $request->input('txt_body_hidden');  

                //     Notification::send(Auth()->user(),new FirebaseNotification($title,$message,$fcmTokens,'ICS News',$announcement->id,$announcement->thumbnail));
                //     //$jsonArray = json_decode($usercontroller->isSuccessPush($token,$title,$description),true);
                // }
            }

           

            // }
               
            return redirect()->route('admin.announcement.index')->with('message','The News is successful ' . ($announcement->send==1?'broadcast':'save') );


            // return Response()->json([
            //     "success" => true, 
            //     'edit_link' => route('admin.announcement.edit',$announcement->id),
               
            // ], Response::HTTP_OK);

        
    }

        public function update(Request $request,Announcement $announcement){

           // return $request->all();
            set_time_limit(8000000);
            if($request->file('imgupload')){
             $validated=request()->validate([
                'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                
             ]);
             
            }

            $validated=request()->validate([
                'txt_body_hidden' => 'required'
            ]);

            if ($files = $request->file('imgupload')) {
                if(strtolower($announcement->thumbnail)!='no-image.png')
                    Storage::delete(['image/' . $announcement->thumbnail]);
                $fileName =  "image-".time().'.'.$request->imgupload->getClientOriginalExtension();
                $request->imgupload->storeAs('image', $fileName);
    
                $data = array(
                    'user_id' => auth()->user()->id,
                    'title' => $request->input('txt_title'),
                    'body' => $request->input('txt_body_hidden'),
                    'thumbnail' => $fileName,
                    'send' => ($request->save_send=='send')?1:$announcement->send,
                );
            }else{
                $data = array(
                    'user_id' => auth()->user()->id,
                    'title' => $request->input('txt_title'),
                    'body' => $request->input('txt_body_hidden'),
                    'send' => ($request->save_send=='send')?1:$announcement->send,
                    
                );
            }

            $announcement->update($data);
            $announcement->classes()->sync($request->input('txt_class', []));

            $tr_id= $announcement->id;
            $image = $announcement->thumbnail;
                //$jsonArray = json_decode($this->isSuccessPush($token,$title,$description),true);


              // $usercontroller = new UsersApiController;
                
                //if(!$request->has('txt_class', [])){
                   if($request->save_send=='send'){
                  //  $firebasetokens = Firebasetoken::get();

                    $announcement->created_at = Carbon::now();
                    $announcement->save(['timestamps'=>false]);
                    

                    $fcmTokens = Firebasetoken::pluck('firebasekey')->toArray();
                    //$fcmTokens = ["fLjZ8lzZSENHoQkWmz3u5V:APA91bHjnuXsbh7rQ975kpQCQwBNG39tj8_h7scm-hxWxWzxfyAvYg_auAEoorqPrbN4WajnsIs5RHIwUwzt2VRr0c4fUmI_PkmtlyQwsir7nHkWK1MReB4AG42pYC9BY6EMPGczPtjl","eoPe7doYA0NIlzh1lgalhP:APA91bGcwcSF4uD3bkcfHtguO-5fFReEU83M40axM00XPqtKgyVsVZokvK2Pv26ldqReu9vNqjrYZJ3qB3bgWR-ze3hkgJcRVFsrBWsMScpMCMCuIh12XImTosQ-kfb5RFzsyc72zRPi","chJyBW_oEEdEqJuTHSoLhm:APA91bF4jBhdojtVtOnIXw6JlQ368LSlyLLqB8HPVSFDr-284SjwTesCnk0QH-PM0JmuxtAlpFFTGDEvBeqy1v9BQd-G6_A1Q0W4LXhDGXBubfw-lUGNMr8GKqKQC5gcVwFts-Y-RDBK"];
                    $title = $request->input('txt_title');
                    $message = $request->input('txt_body_hidden'); 
    
                    Notification::send(Auth()->user(),new FirebaseNotification($title,$message,$fcmTokens,'ICS News',$tr_id)); //$announcement->thumbnail

                    // foreach($firebasetokens as $firebasetoken){
                    //     //$count++;
                    //     //$fcmTokens ='cBwSWbGKT0SwhZAY8YJJHE:APA91bFMYesQKhWzaD12L78sEDfNprCyjQBkJ_IdG_Gh3cAnO2Rj5APXm8kFrszqkmUecsrKSviiCKaF3RkHyn2gDPEhsu1b8leI1gx3ONRZ7QO-xlR31_jvH-npsAVDf6rTC3D-YNcn';
                    //     $fcmTokens = $firebasetoken->firebasekey;
                    //     $title = $request->input('txt_title');
                    //     $message = $request->input('txt_body_hidden');  
                        
                    //     Notification::send(Auth()->user(),new FirebaseNotification($title,$message,$fcmTokens,'ICS News',$tr_id));
                    //     // $announcement->send = $count;
                    //     // $announcement->save(['timestamps'=>false]);

                    //     // $jsonArray = json_decode($usercontroller->isSuccessPush($token,$title,$description),true);
                    // }
                }

                

                
               

                //}
                   
                return redirect()->route('admin.announcement.index')->with('message','The News is successful ' . ($announcement->send==1?'broadcast':'save') );

     }

     public function destroy(Announcement $announcement)
    {
      //  abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!empty($announcement->thumbnail) && ($announcement->thumbnail!='no-image.png'))
            Storage::delete(['image/' . $announcement->thumbnail]);
        $announcement->delete();

        return back();
    }

    
}