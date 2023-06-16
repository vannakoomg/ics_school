<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Gate;
use App\Notifications\FirebaseNotification;
use Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MassDestroyCourseRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use App\SchoolClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Dismissal;
use DataTables;
use App\Userinfo;
use App\CheckinCheckout;
use App\Attendance;

class CallingController extends Controller
{
    
    public function dashboard(Request $request){
        $dimissals = Dismissal::all();        

        if(in_array($request->category,[3,4,5,6]))
            return view('admin.calling.dashboard-monitoring',compact('dimissals'));
        else
            return view('admin.calling.dashboard',compact('dimissals'));
    }


    public function action_notification(Request $request,$rfid){
     
	    $user = User::where('rfidcard',"{$rfid}")->first();

	     if($user){
                    //$tokenkey =['fLjZ8lzZSENHoQkWmz3u5V:APA91bHjnuXsbh7rQ975kpQCQwBNG39tj8_h7scm-hxWxWzxfyAvYg_auAEoorqPrbN4WajnsIs5RHIwUwzt2VRr0c4fUmI_PkmtlyQwsir7nHkWK1MReB4AG42pYC9BY6EMPGczPtjl'];
                    $tokenkey = $user->firebasetokens->pluck('firebasekey')->toArray();

                    $title = "Dimissal Notification";
                    $app_name = "Fingerprint Notification";
                    $message = "{$user->name} scan out ID Card at " . date("H:i A");
                   // Notification::sendNow($user,new FirebaseNotification($message,$title,$tokenkey,$app_name,'0',''));
                      $delay = now()->addMinutes(2);
                      $user->notify((new FirebaseNotification($message,$title,$tokenkey,$app_name,'0',''))->delay($delay));
                }
              return response()->json(['success'=>'true']);
    }

    public function action_update(Request $request, $rfid){
       
        $user = User::where('rfidcard',"{$rfid}")->first();

        if($user){
            if($user->calling->where('status','Waiting')->count()>0){

                $user->calling->where('status','Waiting')->first()->update(['status'=>'TakeOut']); //TakeOut
                //----  add into database sql server attendance --------

  /*             	
		$sqlsvr_userinfo = Userinfo::where('CardNo',"{$rfid}")->first();
                

                if($sqlsvr_userinfo){
                    $data=[
                        'userid' => $sqlsvr_userinfo->USERID,
                        'checktime' => date("Y-m-d H:i:s"),
                        'checktype' => 'O',
                        'verifycode' => 1,
                        'sensorid' => 106,
                        'Memoinfo' => '',
                        'workcode' => 0,
                        'sn' => 'Dimissal',
                        'userextfmt' => 1
                    ];
		 
                   
                    CheckinCheckout::create($data);
		     
		}
*/	
		//---- add into mysql database attandance --------------
                    $data=[
                        'user_id' => auth()->user()->id,
                        'student_id'=> $user->id, 
                        'date' =>  date('Y-m-d h:i'),
                        'status' => 'Present',
                    ];   
    
           //     if(!Attendance::where('student_id',$user->id)->whereDate('date',date('Y-m-d'))->exists())
                    Attendance::create($data);
                //---- send notification -------------
	/*	                
                if($request->send==1){
                    //$tokenkey =['fLjZ8lzZSENHoQkWmz3u5V:APA91bHjnuXsbh7rQ975kpQCQwBNG39tj8_h7scm-hxWxWzxfyAvYg_auAEoorqPrbN4WajnsIs5RHIwUwzt2VRr0c4fUmI_PkmtlyQwsir7nHkWK1MReB4AG42pYC9BY6EMPGczPtjl'];
                    $tokenkey = $user->firebasetokens->pluck('firebasekey')->toArray();
                        
                    $title = "Dimissal Notification";
                    $app_name = "Fingerprint Notification";
                    $message = "{$user->name} scan out ID Card at " . date("H:i A"); 
		   // Notification::sendNow($user,new FirebaseNotification($message,$title,$tokenkey,$app_name,'0',''));
		      $delay = now()->addMinutes(2);
		      $user->notify((new FirebaseNotification($message,$title,$tokenkey,$app_name,'0',''))->delay($delay));
		}
	 */	 
                //---------------------------------------------------------
                
                 return response()->json(['status'=>'success','message' => 'Student Name: ' . $user->name . ' has successfully scan out.','student_id' => $user->email],201);
            }elseif($user->calling->where('status','Takeout')->where('date_time', '>=',date('Y-m-d') . ' 00:00:00')->count()>0){
                 return response()->json(['status'=>'error1','message' => 'Student Name: ' . $user->name . ' is already scan out.'],201);
            }else{
                 return response()->json(['status'=>'error2','message' => 'Student Name: ' . $user->name . ' not in waiting list.'],201);
            }
        }

        return response()->json(['status'=>'error2','message' => 'Invalid Card.'],201);
    }

    public function getwaitingvoice(Request $request){
        if($request->ajax()){
            $campus = $request->input('campus');
          
            $start = $request->startrow;
            $length= empty($request->lengthrow) ? PHP_INT_MAX: $request->lengthrow;

            $path = asset("storage/audio/");
            $data = Dismissal::whereHas('student', function($q) use($request){
                 $q->whereHas('class' , function($q) use($request){
                        $q->where('campus', $request->campus)->when($request->category, function($q) use($request){
                            if($request->category==1)
                                $q->whereIn('level_type',['Kindergarten','Primary']);
                            elseif($request->category==2)    
                                $q->whereIn('level_type',['Secondary']);
                            elseif($request->category==4)    
                                $q->whereIn('level_type',['Kindergarten']);
                            elseif($request->category==5)    
                                $q->whereIn('level_type',['Primary']);    
                            elseif($request->category==6)    
                                $q->whereIn('level_type',['Secondary']);       
                        });
                    });
            })->with(['student' => function($q) use($path){
                $q->select('id','photo','email','voice','rfidcard')->selectRaw("concat('{$path}/',voice) as path");
            }])
            ->whereDate('date_time',date("Y-m-d"))->where('status','Waiting')
            ->skip($start)->take($length)->orderBy('date_time','desc')->get();

            return response()->json($data);

        }
    }

    public function getwaiting(Request $request){
        
        if($request->ajax()){
            $campus = $request->input('campus');
            // $data = Dismissal::whereHas('class' , function($q) use ($campus) {
            //         if($campus!='all')
            //             $q->where('campus',$campus);
            // });
                $start = $request->startrow;
                $length= empty($request->lengthrow) ? PHP_INT_MAX: $request->lengthrow;

               $data = Dismissal::whereHas('student', function($q) use($request){
                    $q->whereHas('class' , function($q) use($request){
                        $q->where('campus', $request->campus)->when($request->category, function($q) use($request){
                            if($request->category==1)
                                $q->whereIn('level_type',['Kindergarten','Primary']);
                            elseif($request->category==2)    
                                $q->whereIn('level_type',['Secondary']);
                            elseif($request->category==4)    
                                $q->whereIn('level_type',['Kindergarten']);
                            elseif($request->category==5)    
                                $q->whereIn('level_type',['Primary']);    
                            elseif($request->category==6)    
                                $q->whereIn('level_type',['Secondary']);        
                        });
                    });
               })
             ->whereDate('date_time',date("Y-m-d"))->where('status','Waiting')
               ->skip($start)->take($length)->orderBy('date_time','desc');
               
               
        
              // return $data->toSql();

        //orderBy('new_at')->get()
            return Datatables::of($data->get())
            ->editColumn('student_id', function(Dismissal $dismissal){
                    return $dismissal->student->email;
            })
            ->addColumn('DT_RowId' , function(Dismissal $dismissal){

                return 'row_' . $dismissal->student->email;
            })
            ->addColumn('thumnail', function(Dismissal $dismissal){
                $html ="<div style='padding:0px;width:110px;height:110px;max-height:110px;background:#ccc;' class='d-inline-block'><div style='width:100%;height:100%;overflow:hidden;'>";

                if(Storage::exists('/photo/' . $dismissal->student->photo) && !empty($dismissal->student->photo))
                       $html .="<img src='" . asset('storage/photo/' . $dismissal->student->photo) . "' style='width:100%;height:auto; ' class='p-0 m-0'>";
                else
                        $html .="<img src='" . asset('storage/image/student-avatar.png') . "' style='width:100%;height:auto' class='p-0 m-0'>";
                
                $html .='</div>';
                
                return $html;
            })
            ->addColumn('detail', function(Dismissal $dismissal){
                // $html="<div class='row'>";
                // $html .="<div class='col align-top'>";

                    $html ='<ul class="list-inline panel-actions2">';
                    $html .='<li><a href="#" class="btn_takeout" data-rfid="' . $dismissal->student->rfidcard . '" data-send="1" data-takeout="'. route('admin.calling.action_update', $dismissal->student->rfidcard) . '" role="button" title="Toggle fullscreen"><i class="fa-solid fa-paper-plane text-primary"></i></a><br/>
                    <a href="#" class="btn_takeout" data-rfid="' . $dismissal->student->rfidcard . '" data-send="0" data-takeout="'. route('admin.calling.action_update', $dismissal->student->rfidcard) . '" role="button" title="Toggle fullscreen"><i class="fa-solid fa-right-from-bracket text-primary"></i></a>
                    </li>';
                    $html .='</ul>';
                    $html .="<div style='padding:3px;width:140px;height:150px;max-height:150px;background:#ccc;' class='d-inline-block'><div style='width:100%;height:100%;overflow:hidden;'>";

                    if(Storage::exists('/photo/' . $dismissal->student->photo) && !empty($dismissal->student->photo))
                           $html .="<img src='" . asset('storage/photo/' . $dismissal->student->photo) . "' style='width:100%;height:auto; ' class='p-0 m-0'>";
                       else
                           $html .="<img src='" . asset('storage/image/student-avatar.png') . "' style='width:100%;height:auto' class='p-0 m-0'>";

                    $html .="</div></div>";
                   $html .='<h2 class="d-inline-block m-0 align-top" style="padding-left:5px;padding-top:10px">' . $dismissal->student->namekh . '<br/>' . $dismissal->student->name   .'<br/><span class="" style="font-size:90%">' . $dismissal->student->class->name . '</span><br/><span class="small ' . (($dismissal->date_time->diffInMinutes()>=5)?'text-danger':'text-primary') . '">' . $dismissal->date_time->diffForHumans() .'</span></h2>';
                    

                // $html .= '</div>';
                return $html;
            })
            ->addColumn('voice', function(Dismissal $dismissal){
                return $dismissal->student->voice;
             })
             ->addColumn('path', function(Dismissal $dismissal){
                return asset("storage/audio/" . $dismissal->student->voice);
             })
             ->addColumn('rfid', function(Dismissal $dismissal){
                return $dismissal->student->rfidcard;
             })
            ->addColumn('name', function(Dismissal $dismissal){
                return $dismissal->student->name;
            })
            ->addColumn('namekh', function(Dismissal $dismissal){
                return $dismissal->student->namekh;
            })
            ->addColumn('class_name', function (Dismissal $dismissal) {
                    return $dismissal->student->class->name;
            })
            ->addIndexColumn()
            // ->addColumn('action' , function(Dismissal $dismissal){
            //     return '<a href="#" class="btn btn-primary text-nowrap btn_takeout" data-rfid="' . $dismissal->student->rfidcard . '" data-takeout="'. route('admin.calling.action_update', $dismissal->student->rfidcard) .'">Take Out</a>';
            // })
            ->addColumn('time', function(Dismissal $dismissal){
                return $dismissal->gettime();
            })
            ->addColumn('duration', function(Dismissal $dismissal){
                return $dismissal->date_time->diffForHumans();
            })
            ->addColumn('action', function(Dismissal $dismissal){
                return '<a href="#" class="btn  btn-success btn_takeout text-nowrap" data-send="1" data-rfid="' . $dismissal->student->rfidcard . '" data-takeout="'. route('admin.calling.action_update', $dismissal->student->rfidcard) . '"><i class="fa-solid fa-paper-plane"></i></a> <a href="#" class="btn btn-info btn_takeout text-nowrap" data-send="0" data-rfid="' . $dismissal->student->rfidcard . '" data-takeout="'. route('admin.calling.action_update', $dismissal->student->rfidcard) . '"><i class="fa-solid fa-right-from-bracket"></i></a>';
            })
            ->rawColumns(['detail','action','thumnail'])
            // ->setTotalRecords(5)
            ->make(true);

         }
    }

}
