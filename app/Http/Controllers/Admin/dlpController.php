<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Notification;
use Symfony\Component\HttpFoundation\Response;
use App\SchoolClass;
use App\Dlp;
use DataTables;
use NotifiersHelpers;
use Notify;
use App\User;
use Session;
use Pusher\PushNotifications\PushNotifications;
use App\Notifications\DlpNotification;
use Carbon\Carbon;

class dlpController extends Controller
{

//     public function notify($message){
//     $notification = (new Notification())
//         ->setTitle(config('app.name') . ' DLP')
//         ->setBody($message)
//         ->addOption(
//             'sound',
//             'glass'
//         );
//
//         $this->app->make('desktop.notifier')->send($notification);
//     }

//    protected $beamsClient;
//
//    public function __construct(){
//         $this->beamsClient  = new PushNotifications(array(
//               "instanceId" => env('PUSHER_APP_KEY'),
//               "secretKey" => env('PUSHER_APP_SECRET'),
//         ));
//     }

    public function report(){
        
        return view('admin.dlp-report');
    }

    public function index(){
         // $schoolClasses = SchoolClass::all();
          $problem_types= $this->getProblemValues();
          $status = $this->getStatusValues();
          //dd($pushNotifications);
//           dd(User::whereHas('roles', function($role) {
//             $role->where('title','dlp-admin')->orWhere('title','dlp-monitoring');
//         })->pluck('name')->toArray());
//             dd(auth()->user()->roles()->where('title','dlp-support')->exists());
          return view('admin.dlp',compact('problem_types','status'));
    }

    public static function getProblemValues() {
      $type = DB::select(DB::raw("SHOW COLUMNS FROM dlp WHERE Field = 'problem_type'"))[0]->Type ;
      $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));

      return $enum;
    }

    public static function getStatusValues() {
      $type = DB::select(DB::raw("SHOW COLUMNS FROM dlp WHERE Field = 'status'"))[0]->Type ;
      $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));

      return $enum;
    }

    public function getClass(Request $request){
        if($request->ajax()){
            $campus = $request->input('campus');

            $schoolClasses = SchoolClass::withCount(['classDlp as new' =>  function($q){
                 $q->where('status','New');
            }])->withCount(['classDlp as received' =>  function($q){
                 $q->where('status','In progress');
            }])->withCount(['classDlp as overdue' =>  function($q){
                 $q->where('status','In progress')
                 ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, received_at, NOW())) > 15');
            }]);

           if($request->input('campus')=='all')
              $schoolClasses = $schoolClasses->get();
           else
              $schoolClasses = $schoolClasses->where('campus',$request->input('campus'))->get();

            $all_new = Dlp::whereHas('class', function($q) use ($campus){
                if($campus != 'all')
                    $q->where('campus',$campus);
            })
            ->where('status','New')->count();

            $all_process = Dlp::whereHas('class', function($q) use ($campus){
                if($campus != 'all')
                    $q->where('campus',$campus);
            })
            ->where('status','In progress')->count();

            $all_overdue = Dlp::whereHas('class', function($q) use ($campus){
                if($campus != 'all')
                    $q->where('campus',$campus);
            })
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, received_at, NOW())) > ?' ,[15])->where('status','In progress')->count();

            $all = array('new'=>$all_new, 'received' => $all_process, 'overdue' => $all_overdue);

            $data = array('all'=>$all,'class'=>$schoolClasses);

            return json_encode($data);
        }


    }


    public function getDlp(Request $request){

        if($request->ajax()){
            $campus = $request->input('campus');
            $data = Dlp::whereHas('class' , function($q) use ($campus) {
                    if($campus!='all')
                        $q->where('campus',$campus);
            });

            if($request->input('class_id')!=0){
                $data=$data->where('class_id',$request->input('class_id'));

                if($request->input('closed_status')=='false')
                    $data=$data->where('status','!=','Closed');
             }

            if($request->has('date_fr') && $request->has('date_to')){
                $date_fr =  Carbon::createFromFormat('d/m/Y', $request->date_fr)->format("Y-m-d"); 
                $date_to =  Carbon::createFromFormat('d/m/Y', $request->date_to)->format("Y-m-d"); 

                $data = $data->whereDate('created_at','>=',$date_fr)->whereDate('created_at','<=',$date_to);
            }else{
              
                if($request->input('closed_status')=='false')
                    $data=$data->where('status','!=','Closed');
                else
                    $data=$data->whereDate('created_at','=',date('Y-m-d'));
            }

            //return $data->toSql();

        //orderBy('new_at')->get()
            return Datatables::of($data->get())
            ->addColumn('created_date', function(Dlp $dlp){
                    return $dlp->mydate();
            })
            ->addColumn('full_path', function (Dlp $dlp) {
//                 return storage_path('public/image' . $dlp->image);
//                 return Image::make(storage_path('public/' . $dlp->image));
                if(empty($dlp->image))
                    return "<img src='" . asset('images/no-image.png') . "' width='100px'>";
                else
                    return "<A target='new' href='" . asset('storage/image/' .  $dlp->image) . "'> <img src='" . asset('storage/image/' .  $dlp->image) . "' width='100px'>";
            })
            ->addColumn('class', function (Dlp $dlp) {
                    return $dlp->class->name;
                })
            ->addIndexColumn()
//             ->editColumn('problem_type', function(Dlp $d) {
//
//                     return $d->problem_type . '<br/><span class="small text-primary">' . date_format($d->new_at,'d/m/Y h:i:s a') . '</span><br/><span class="small text-info">' . $d->newby->name . '</span>' ;
//                 })
            ->editColumn('problem', function(Dlp $d) {
                    return $d->problem . '<br/><span class="small text-primary">' . date_format($d->new_at,'d/m/Y h:i:s a') . '</span><br/><span class="small text-info">Posted by ' . $d->newby->name . '</span>';
                })
            ->editColumn('solution', function(Dlp $d) {
                    $received_solved = ($d->status=='Received')?'Received by ':'Solved by ';
                    if(!empty($d->solution))
                        return $d->solution . '<br/><span class="small text-primary">' . date_format($d->received_at,'d/m/Y h:i:s a') . '</span><br/><span class="small text-info">' . $received_solved . $d->receivedby->name . '</span>';
                    else
                        return '';
                })
            ->editColumn('status', function(Dlp $d) {
                    if($d->status=='New'){
                        $txt_color = 'badge-primary';
                        $date_time = date_format($d->new_at,'d/m/Y h:i:s a');
                        $user_name =  $d->newby->name;
                    }else if(in_array($d->status, array('In progress'))){
                        $txt_color = 'badge-info';
                        $date_time = date_format($d->received_at,'d/m/Y h:i:s a');
                        $user_name =  $d->receivedby->name;

                     }else if(in_array($d->status, array('Completed'))){
                        $txt_color = 'badge-success';
                        $date_time = date_format($d->received_at,'d/m/Y h:i:s a');
                        $user_name =  $d->receivedby->name;
                    }else{
                        $txt_color = 'badge-dark';
                        $date_time = date_format($d->closed_at,'d/m/Y h:i:s a');
                        $user_name =  $d->closedby->name;
                    }

                    return '<span class="badge ' . $txt_color . '">' . $d->status . '</span><br/><span class="small text-primary text-nowrap">' . $date_time . '</span><br/><span class="small text-info">' . $user_name . '</span>';

                })
            ->addColumn('action' , function(Dlp $d){

                $btn_progress = "<a href='#' class='btn btn-sm btn-info btn_action text-nowrap' data-id='{$d->id}' data-value='in progress' >In progress</a><br/>";
                $btn_completed = "<a href='#' class='btn btn-sm btn-success btn_action' data-id='{$d->id}' data-value='completed'>Complete</a><br/>";
                $btn_closed = "<a href='#' class='btn btn-sm btn-dark btn_action' data-id='{$d->id}' data-value='closed'>Close</a>";
                $display_button ='';
                if($d->status == 'New' && (auth()->user()->isdlpsupport || auth()->user()->isdlpadmin))
                   $display_button = $btn_progress;
                else if($d->status == 'In progress' && (auth()->user()->isdlpsupport || auth()->user()->isdlpadmin))
                   $display_button = $btn_completed;
                else if(($d->status == 'Completed') && (auth()->user()->isdlpmonitoring || auth()->user()->isdlpadmin))
                   $display_button = $btn_closed;

                return $display_button;
            })
            ->rawColumns(['problem_type','problem','status','action','created_date','full_path','solution'])
            ->make(true);

         }
    }


    public function addnew(Request $request){

        if($request->ajax()){
            $fileName='';
            if ($files = $request->file('txtimage')) {
                $fileName =  "image-".time().'.'.$request->txtimage->getClientOriginalExtension();
                $request->txtimage->storeAs('image', $fileName);
            }

            $data=array(
                 'class_id' => $request->input('txt_class_id'),
                 'problem_type' => $request->input('lst_type'),
                 'problem' => $request->input('txt_problem'),
                 'status' => 'New',
                 'new_at' => now(),
                 'new_by' => auth()->user()->id,

            );

            if(!empty($fileName))
                  $data['image'] = $fileName;


            Dlp::create($data);

            $cls=SchoolClass::find($request->input('txt_class_id'));

             $details = [
                    "title" => $cls->name . ": " . $data['problem'] ,
                     "body" => "Posted by: " . auth()->user()->name,
                     "deep_link" => "https://webschool.ics.edu.kh/admin/dlp",
            ];


            Notification::send(auth()->user(), new DlpNotification($details));

            return json_encode(['success'=>true, 'data'=>$data , 'title' => 'Posted by: ' . auth()->user()->name , 'message' => '[' .  $cls->name . '],' . $data['problem']]);
        }
    }

     public function update(Request $request){   //Support team

        if($request->ajax()){
             $dlp = Dlp::find($request->dlp_id);


            if(in_array($dlp->status,array('In progress','New'))){
               $data=array(
                 'solution' => empty($request->input('solution'))?$dlp->solution:$request->input('solution'),
                 'status' => $request->input('status'),
                 'received_at' => now(),
                 'received_by' => auth()->user()->id,
//                  'timestamps' => false,
//                  'created_at' => $dlp->created_at,
              );

            }else{
                 $data=array(
                 'status' => $request->input('status'),
                 'closed_at' => now(),
                 'closed_by' => auth()->user()->id,
                 'timestamps' => false,
//                  'created_at' => $dlp->created_at,
              );
            }

            $dlp->fill($data);
            $dlp->save();

            $details = [
                    "title" => $dlp->class->name . ": " . $dlp->problem ,
                     "body" => "Status changed to {$request->input('status')}",
                     "deep_link" => "https://webschool.ics.edu.kh/admin/dlp",
            ];

            $users= User::first();

//     $beamsClient = new \Pusher\PushNotifications\PushNotifications(
//       array(
//        'instanceId' => '8aefb6b4-0974-4390-90cd-0adeb1514910',
//        'secretKey'  => 'E1581BA1EAEBCED979ACD8902BC98170DE3536E1584360DA0FD883433A254BEF',
//        )
//  );
//
//             $publishResponse = $beamsClient->publishToUsers(
//            array('Admin'),
//            array(
//             "web" => array(
//                 "notification" => array(
//                 "title" => "Hi!",
//                  "body" => "This is my first Push Notification!"
//             )),
//             ));




             Notification::send($users , new DlpNotification($details));
            //$users->notify(new DlpNotification($details));

            return json_encode(['success'=>true, 'data'=>$data]);

         }
      }

}
