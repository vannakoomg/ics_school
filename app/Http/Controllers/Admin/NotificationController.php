<?php

namespace App\Http\Controllers\Admin;

use App\SchoolClass;
use App\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use Validator;
use Notification;
use App\Notifications\FirebaseNotification;
use App\Firebasetoken;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    public function index(Request $request){
        
        if($request->chk_show=='on')
            $messages = Message::orderBy('created_at','desc')->get();
         else
            $messages = Message::where('send','0')->orderBy('created_at','desc')->get();
            // $feedbacks = Feedback::where('reply','0')->orderBy('created_at','desc')->get();


        return view('admin.notifications.index', compact('messages'));
    }

    public function show(Message $message){
        $classes = SchoolClass::all();
        return view('admin.notifications.show',compact('message','classes'));
    }

    public function create(){
        $classes = SchoolClass::all();
        
        $primary_mc = SchoolClass::where('campus','mc')->where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten_mc = SchoolClass::where('campus','mc')->where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary_mc = SchoolClass::where('campus','mc')->where('level_type','Secondary')->pluck('id')->toArray();

        $primary_cc = SchoolClass::where('campus','cc')->where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten_cc = SchoolClass::where('campus','cc')->where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary_cc = SchoolClass::where('campus','cc')->where('level_type','Secondary')->pluck('id')->toArray();

        $filter = [
            'primary-mc' => $primary_mc,
            'kindergarten-mc' => $kindergarten_mc,
            'secondary-mc' => $secondary_mc,
            'primary-cc' => $primary_cc,
            'kindergarten-cc' => $kindergarten_cc,
            'secondary-cc' => $secondary_cc
        ];
       // dd($primary_mc);
        return view('admin.notifications.create', compact('classes','filter'));
    }


    public function edit(Message $message){
        $classes = SchoolClass::all();

        $primary_mc = SchoolClass::where('campus','mc')->where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten_mc = SchoolClass::where('campus','mc')->where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary_mc = SchoolClass::where('campus','mc')->where('level_type','Secondary')->pluck('id')->toArray();

        $primary_cc = SchoolClass::where('campus','cc')->where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten_cc = SchoolClass::where('campus','cc')->where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary_cc = SchoolClass::where('campus','cc')->where('level_type','Secondary')->pluck('id')->toArray();

        $filter = [
            'primary-mc' => $primary_mc,
            'kindergarten-mc' => $kindergarten_mc,
            'secondary-mc' => $secondary_mc,
            'primary-cc' => $primary_cc,
            'kindergarten-cc' => $kindergarten_cc,
            'secondary-cc' => $secondary_cc
        ];

        return view('admin.notifications.edit', compact('classes','message','filter'));
    }

    public function store(Request $request){
      //if($request->file('imgupload')){
        //  dd($request->all());
        //  $validate = Validator::make($request->all(), [
        //     'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //  ]);

        // if($validate->fails())
        //     return redirect()->back()->withErrors($validate)->withInput();
      //}
        // $request->validate([
        //     'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);




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

            $message = Message::create($data);
            $message->classes()->sync($request->input('txt_class', []));
           
            if($request->save_send=='send'){

                if($request->has('txt_class')){
                    
                   $students = User::whereHas('roles', function($q){
                       $q->whereId(4);
                   })->whereHas('class', function($q) use($request){
                        $q->whereIn('class_id',$request->input('txt_class', []))  ;
                   })
                   ->has('firebasetokens')
                   ->get();

                  
                //    $fcmTokens = Firebasetoken::whereHas('users', function($q) use($request){
                //         $q->whereHas('class', function($q) use ($request){
                //             $q->whereIn('class_id',$request->input('txt_class', []));
                //         });
                //     })->pluck('firebasekey')->toArray();

                }else{

                    // $fcmTokens = Firebasetoken::has('users')->pluck('firebasekey')->toArray();
                    $students = User::whereHas('roles', function($q){
                        $q->whereId(4);
                    })->has('class')
                    ->has('firebasetokens')
                    ->get();

                }


                $title = $request->input('txt_title');
                $body = $request->input('txt_body_hidden');  

                foreach($students as $student){
                    $fcmTokens=$student->firebasetokens()->pluck('firebasekey')->toArray();
                    $student->notify(new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message'));   
                }

                // Notification::send(Auth()->user(),new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,'','message')); //$message->thumbnail

                // $exist = [];    
                // foreach($firebasetokens as $firebasetoken){
                    
                //     $fcmTokens = $firebasetoken->firebasekey;
                //     // $title = $request->input('txt_title');
                //     // $body = $request->input('txt_body_hidden');  
                    
                //     $students = User::whereHas('firebasetokens',function($q) use ($firebasetoken){
                //                 $q->where('firebasetoken_id',$firebasetoken->id);
                //         })->when($request->has('txt_class'),function($q) use($request){

                //                 $q->whereHas('class',function($q) use ($request){
                //                         $q->whereIn('class_id',$request->input('txt_class', []));
                //                 });       
                //         })->get();
        
                //         // foreach($students as $student){
                //         //     $student->notify(new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message', !in_array($student->id,$exist)));
                //         //     $exist[] = $student->id;
                //         // }
                //   //  Notification::send($students,new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message'));
                //     //$jsonArray = json_decode($usercontroller->isSuccessPush($token,$title,$description),true);
                // }
            }

            // }
               
            return redirect()->route('admin.message.index')->with('message','Notification is successful ' . ($message->send==1?'broadcast':'save') );
            // return Response()->json([
            //     "success" => true, 'edit_link' => route('admin.message.edit',$message->id)
            // ], Response::HTTP_OK);

        

    }

        public function update(Request $request,Message $message){

        //    dd($request->all());
            if($request->file('imgupload'))
                $request->validate([
                    'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        
            if ($files = $request->file('imgupload')) {

                if(strtolower($message->thumbnail)!='no-image.png')
                    Storage::delete(['image/' . $message->thumbnail]);
                Storage::delete(['image/' . $message->thumbnail]);
                $fileName =  "image-".time().'.'.$request->imgupload->getClientOriginalExtension();
                $request->imgupload->storeAs('image', $fileName);
    
                $data = array(
                    'user_id' => auth()->user()->id,
                    'title' => $request->input('txt_title'),
                    'body' => $request->input('txt_body_hidden'),
                    'thumbnail' => $fileName,
                    'send' => (($request->save_send=='send'))?1:$message->send,
                );
            }else{
                $data = array(
                    'user_id' => auth()->user()->id,
                    'title' => $request->input('txt_title'),
                    'body' => $request->input('txt_body_hidden'),
                    'send' => ($request->save_send=='send')?1:$message->send,
               
                );
            }

                $message->update($data);
                $message->classes()->sync($request->input('txt_class', []));

                $tr_id= $message->id;
                $image = $message->thumbnail;
                //$jsonArray = json_decode($this->isSuccessPush($token,$title,$description),true);

          
              // $usercontroller = new UsersApiController;
                
                //if(!$request->has('txt_class', [])){
                    if($request->save_send=='send'){

                        $message->created_at = Carbon::now();
                        $message->save(['timestamps'=>false]);

                        if($request->has('txt_class')){
                            
                            $students = User::whereHas('roles', function($q){
                                $q->whereId(4);
                            })->whereHas('class', function($q) use($request){
                                 $q->whereIn('class_id',$request->input('txt_class', []))  ;
                            })
                            ->has('firebasetokens')
                            ->get();
                           
                          
                        }else{
        
                            $students = User::whereHas('roles', function($q){
                                $q->whereId(4);
                            })->has('class')
                            ->has('firebasetokens')
                            ->get();
        
                        }
                        
                        $title = $request->input('txt_title');
                        $body = $request->input('txt_body_hidden');  

                        foreach($students as $student){
                            $fcmTokens=$student->firebasetokens()->pluck('firebasekey')->toArray();
                            $student->notify(new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message'));   
                        }
                        
                        // $students = User::whereHas('firebasetokens',function($q) use ($firebasetoken){
                        //     $q->where('firebasetoken_id',$firebasetoken->id);
                        // })->when($request->has('txt_class'),function($q) use($request){
                        //         $q->whereHas('class',function($q) use ($request){
                        //                 $q->whereIn('class_id',$request->input('txt_class', []));
                        //         });       
                        // })->get();
                        
                      //  $fcmTokens = ["fLjZ8lzZSENHoQkWmz3u5V:APA91bHjnuXsbh7rQ975kpQCQwBNG39tj8_h7scm-hxWxWzxfyAvYg_auAEoorqPrbN4WajnsIs5RHIwUwzt2VRr0c4fUmI_PkmtlyQwsir7nHkWK1MReB4AG42pYC9BY6EMPGczPtjl","eoPe7doYA0NIlzh1lgalhP:APA91bGcwcSF4uD3bkcfHtguO-5fFReEU83M40axM00XPqtKgyVsVZokvK2Pv26ldqReu9vNqjrYZJ3qB3bgWR-ze3hkgJcRVFsrBWsMScpMCMCuIh12XImTosQ-kfb5RFzsyc72zRPi","chJyBW_oEEdEqJuTHSoLhm:APA91bF4jBhdojtVtOnIXw6JlQ368LSlyLLqB8HPVSFDr-284SjwTesCnk0QH-PM0JmuxtAlpFFTGDEvBeqy1v9BQd-G6_A1Q0W4LXhDGXBubfw-lUGNMr8GKqKQC5gcVwFts-Y-RDBK"];

                       // Notification::send(Auth()->user(),new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,'','message'));

                        //$exist = [];
                        // foreach($firebasetokens as $firebasetoken){
                            
                        //     $fcmTokens = $firebasetoken->firebasekey;
                        //     $title = $request->input('txt_title');
                        //     $body = $request->input('txt_body_hidden');  
                           
            

                           // return $students;

                            // foreach($students as $student){
                            //     $student->notify(new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message', !in_array($student->id,$exist)));
                            //     $exist[] = $student->id;
                            // }
                            // (new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message'))->unique()->notify($students);
                          //  Notification::send($students,new FirebaseNotification($title,$body,$fcmTokens,$title,$message->id,$message->thumbnail,'message'));
                            //$jsonArray = json_decode($usercontroller->isSuccessPush($token,$title,$description),true);
                        //}
                    }
                //}

    
                return redirect()->route('admin.message.index')->with('message','Notification is successful ' . ($message->send==1?'broadcast':'save') );

     }

     public function destroy(Message $message)
    {
      //  abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!empty($message->thumbnail) && ($message->thumbnail!='no-image.png'))
            Storage::delete(['image/' . $message->thumbnail]);
        $message->delete();

        return back();
    }

    
}
