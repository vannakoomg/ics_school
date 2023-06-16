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
use App\Timetable;
use Notification;
use App\Notifications\FirebaseNotification;
use Illuminate\Support\Facades\DB;
use Auth;
use App\ScheduleTemplateDetail;
use App\ScheduleTemplate;
use App\SchoolClass;

class TimetableApiController extends Controller
{

    public $successStatus = 200;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserResource(User::with(['roles', 'class'])->get());
    }
    

    public function gettimetable(Request $request){   // Auth

        if(!$request->has('week_of_day') || !$request->has('type'))
            return response()->json(['status'=>false,'message'=>'Week of day and Type paramater are required for this API.','data'=>[]], 401);


        // $timetables = ScheduleTemplate::whereHas('school_class', function($q){
        //     $q->where('class_id', auth()->user()->class->id);
        // })->with('detail')->get();

        // $timetables = auth()->user()->class->timetable->map(function ($table) use($request){
        //     $table->col_val = $table->{$request->week_of_day};
        //     $table->start_time = $table->template_detail->start_time;
        //     $table->end_time = $table->template_detail->end_time;
        //     $table->breaktime =  $table->template_detail->breaktime;
        //     $table->class = $table->class;
        //     //unset($table['template_detail']);

        //     return $table;
        // });

        // $types = ScheduleTemplate::whereHas('detail', function($q) {
        //         $q->whereHas('timetable' , function($q){
        //             $q->where('class_id',auth()->user()->class->id);
        //         });
        // })
        // ->pluck('type')->toArray();
        
        $types=auth()->user()->class->schedule_template->pluck('type')->toArray();
       
      // return response()->json(auth()->user()->class->schedule_template->pluck('type')->toArray());
       if(in_array($request->type,$types))
            $types = $request->type;
       else
            $types = 'Both';

        $schedule_template = auth()->user()->class->schedule_template->where('type',$types)->first();
      
        // return response()->json();

      $timetables1 = ScheduleTemplateDetail::select('id','school_template_id','start_time','end_time','breaktime',DB::raw('"" as col_val'))
        ->whereHas('scheduletemplate', function($q) use($types){
            $q->whereHas('school_class', function($q){
                $q->where('class_id',Auth::user()->class->id);
            })->where('type',$types)->where('breaktime','!=','Study Time');
      });

     // return response()->json($timetables1->get());

      $timetables = Timetable::rightjoin('schedule_template_detail','timetable.template_detail_id','=','schedule_template_detail.id')
      ->join("schedule_template","schedule_template_detail.school_template_id","=","schedule_template.id")
      ->select('schedule_template_detail.id','school_template_id','start_time','end_time','schedule_template_detail.breaktime', DB::raw($request->week_of_day . ' as col_val'))
      ->where('type',$types)
      ->where('schedule_template_detail.breaktime','Study Time')
      ->where('class_id',Auth::user()->class->id)
      ->where('timetable.template_id', $schedule_template->pivot->schedule_template_id ?? 0)
     ->union($timetables1)
      ->orderBy('start_time','asc')
      ->get();
      
      $class=auth()->user()->class;

      //return response()->json(['sql'=>$timetables]);

        // $timetables = Timetable::rightjoin('schedule_template_detail','timetable.template_detail_id','=','schedule_template_detail.id')
        //     ->join("schedule_template","schedule_template_detail.school_template_id","=","schedule_template.id")
        //    ->select(['schedule_template_detail.*','timetable.' . $request->week_of_day . ' as col_val'])
        //     ->when($types, function($query) use($types, $request){
        //         if(in_array('Both',$types)){
                   
        //             $query->whereIn('schedule_template.type', ['Both'])->where(function($q){
        //                 $q->where('timetable.class_id',auth()->user()->class->id)->orWhereNull('timetable.class_id');
        //             });
        //         }else if(in_array('Odd',$types) || in_array('Even',$types) ){
        //             $query->whereIn('schedule_template.type', [$request->type])->where(function($q){
        //                 $q->where('timetable.class_id',auth()->user()->class->id)->orWhereNull('timetable.class_id');
        //             });
        //         }
        //     })->whereIn('schedule_template.type',$types)
        //     ->orderBy('schedule_template_detail.start_time');

            // return response()->json(['sql'=>$timetables->toSql()]);

           // dd($timetables->toSql());
            //>map(function ($table) use($request){
            // $table->class = $table->school_class;
            // $table->schedule = $table->detail
            //$table->col_val = $table->{$request->week_of_day};
            // $table->start_time = $table->template_detail->start_time;
            // $table->end_time = $table->template_detail->end_time;
            // $table->breaktime =  $table->template_detail->breaktime;
            // $table->class = $table->class;
           // $table->details = $table->detail;
           // $table->timetables = $table->detail->timetable;
            //unset($table['template_detail']);
         //   $table->timetable = $table->detail->timetable; 
        //     $table->class = $table->school_class->where('id',auth()->user()->class->id)->first();
            
        //     unset($table['school_class']);

        //     $table->detail->map(function($subtable1) use ($request,$table){
               
        //         $subtable1->classtimetable();
        //         unset($subtable1->classtimetable);
        //         //$subtable1->timetable->map(function($subtable2) use($request, $subtable1,$table){

                   
        //         //     $subtable1->col_val = $subtable1->{$request->week_of_day};
        //         //     $subtable1->start_time = $subtable1->start_time;
        //         //     $subtable1->end_time = $subtable1->end_time;
        //         //     $subtable1->breaktime =  $subtable1->breaktime;

        //         //     if($subtable2->class_id!=7){
        //         //        unset($subtable1->timetable);
        //         //     }
                    
        //         //     return $subtable2;
                    
        //         // });

        //        // unset($subtable1['timetable']);
        //    // }
              
        //         // $table->timetables = $subtable1->timetable;
        //         //unset($table['detail']);
        //         return $subtable1;
        //    });

        //     return $table;
        // });

        // $new_data['class'] = $timetables[1]->class; 
        // foreach($timetables[1]->detail as $detail){
        //     $new_data['timetables'][] =  $detail->timetable;
        // }
        // $timetables->put('newcolumn',445);
        // $scheduletemplatedetails = ScheduleTemplateDetail::with(['timetable.class' => function($q) use($class_selected){
        //     //    $q->whereHas('timetable', function($q) use($class_selected) {
        //     //         $q->where('class_id',1);
        //     // });
        // }])
        // ->where('school_template_id',$template_selected)
        // ->oldest('start_time')->get();

        // $timetables =  Timetable::with(['class'=> function($q){
        //     $q->select('id','name as class_name','campus','roomno','homeroom_id','khteacher_id','teacheraide_id');
        // }])->select('id','start_time','end_time','class_id','breaktime',$request->week_of_day . ' as col_val')->where('class_id',Auth::user()->class->id)->where(function($q) use ($request){
        //     $q->whereNotNull($request->week_of_day)->orWhereNotNull('breaktime');
        // })->oldest('start_time')->get();

        $data = ['class'=> $class, 'timetables' => $timetables];

        $data=['status'=>true,'message'=>'Schedule List','data'=> $data];

        return response()->json($data, $this->successStatus);

    }
    
    

}
