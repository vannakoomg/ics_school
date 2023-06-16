<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Attendance;
use App\SchoolClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function index(Request $request){
    
    if($request->has('campus'))
        $selected_campus=SchoolClass::where('campus',$request->input('campus'))->first();
    else
        $selected_campus=SchoolClass::groupBy('campus')->first();

    if($request->has('class'))
        $selected_class = SchoolClass::find($request->input('class'));
    else
        $selected_class = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->first();
  
    $schoolClasses = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->get();
   
    $students = User::whereHas('roles', function ($query){
            $query->whereId(4);
        })->whereHas('class', function($query) use ($selected_class){
             $query->where('id',$selected_class->id);
        })
    ->get();

    $year = empty($request->cur_year) ? date('Y'):$request->cur_year;
    $month = empty($request->cur_month) ? date('m'):$request->cur_month;
     
    $period = CarbonPeriod::create(date("{$year}-{$month}-1"), date('Y-m-t',strtotime("{$year}-{$month}-1")));
    $dateRanges = [];
    foreach ($period as $date) {
        //array_unshift($dateRanges, $date->format('Y-m-d'));
        $dateRanges[]=$date->format('Y-m-d');
    }

    $date1 = Carbon::createFromFormat('Y-m-d',"{$year}-{$month}-1");
    $date2 = Carbon::createFromFormat('Y-m-d',"{$year}-{$month}-1");

    $dateRange = [
        $date2->setTime(0, 0, 0)->format('Y-m-d'),
        $date1->endOfMonth()->setTime(0, 0, 0)->format('Y-m-d')
    ];
    
    $attendances = Attendance::whereHas('students', function($q) use($selected_class){
        $q->whereHas('roles', function ($query) use($selected_class){
                $query->whereId(4);
        })->whereHas('class', function($query) use ($selected_class){
            $query->where('id',$selected_class->id);
        });
    })
    ->whereBetween('date', $dateRange)
    ->get()
    ->groupBy('student_id')
    ->map(function ($items) {
                $arr = [];
        foreach($items as $item){
            $status = $item->status;
            switch(strtolower($status)){
                case 'present':
                    $symbold='<i class="fas fa-check-circle text-primary"></i>';
                    break;
                case 'absent & excused':
                    $symbold='<i class="fas fa-times-circle text-warning"></i>';
                    break;    
                case 'absent & unexcused':
                    $symbold='<i class="fas fa-times-circle text-danger"></i>';
                    break;     
                default:
                    $symbold ='';      

            }
            $arr[$item->date->format('Y-m-d')]=$symbold;
        }
        return $arr;
    })
    ->toArray(); 
    
    //dd($attendances);
    $status = $this->getStatusValue();

    return view('admin.attendance.index',compact('schoolClasses','selected_class','selected_campus','students','status','attendances','dateRanges'));

    }

    private static function getStatusValue() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM attendances WHERE Field = 'status'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
    }

    public function store(Request $request){

        if($request->has('student_id')){
            $students = $request->input('student_id',[]);
            $attendance = $request->input('txt_status',[]);
            $remark = $request->input('txt_remark',[]);
            // $classes = $request->input('class_id',[]);
            $date = Carbon::createFromFormat('d/m/Y', $request->txt_date)->setTime(8, 30, 00)->format("Y-m-d H:i:00");  
          
            $data=[];
            foreach( $students as $key=>$student){
                $data =  [
                    'user_id'=> auth()->user()->id,
                    'student_id' => $student,
                    'date' => $date,
                    'status' => $attendance[$key],
                    'remark' =>  $remark[$key]
       
                ];

                

                $Attendance = Attendance::whereDate('date',date_format(date_create($date),"Y-m-d"))->where('student_id',$student)->orderBy('id','desc')->first();
                if($Attendance)
                    $Attendance->update($data);
                else
                    Attendance::create($data);
                
                
            }

            return redirect()->route('admin.attendance.index')->with('message','The Attendance was recorded.');
            
            
        }

        return redirect()->back();
         


    }




    public function generateattendance(Request $request){
   
        if($request->has('campus'))
            $selected_campus=SchoolClass::where('campus',$request->input('campus'))->first();
        else
            $selected_campus=SchoolClass::groupBy('campus')->first();

        //----- For Save Attendance ------------
        $students_present = $request->present;
       
       // dd($students_present, $request->class_id);

        if($request->has('class_id')){
     
            foreach($request->class_id as $k=>$class_id){
                $students_presents = explode(",",$students_present[$k]);
            
                if(is_array($students_presents) && $students_presents[0]!=""){
                    foreach($students_presents as $student_id){
                    // echo $student_id . "--" .  $class_id . "<br>";
                    $cur_datetime =Carbon::now();
                    Attendance::updateOrCreate(
                        [
                            'date' => date_format(date_create($cur_datetime),"Y-m-d"),
                            'student_id' => $student_id],  
                        [
                        'user_id' => auth()->user()->id,
                        'date' => $cur_datetime->setTime(8, 30, 00)->toDateTimeString(),
                        // 'date' => date('Y-m-d'),
                        // 'student_id' => $student_id,
                        'status' => 'Present',
                        ]
                    );
                }
                }

                }

                return redirect()->route('admin.attendance.generate'); 
           
        }

        //--------- end of save attendance --------
      
        $schoolClasses = SchoolClass::where('campus',$selected_campus->campus)
        ->withCount(['classUsers as total' =>  function($q){
                $q->groupBy('class_id');
        }])
        ->withCount(['classUsers as present' =>  function($q){
            $q->whereHas('attendances', function($q){
                $q->where('date',date('Y-m-d'))->where('status','=','Present')->groupBy('student_id');
            })->groupBy('class_id');
        }])
        ->withCount(['classUsers as absent_excused' =>  function($q){
            $q->whereHas('attendances', function($q){
                $q->where('date',date('Y-m-d'))->where('status','=','Absent & Excused')->groupBy('student_id');
            })->groupBy('class_id');
        }])
        ->withCount(['classUsers as absent_unexcused' =>  function($q){
            $q->whereHas('attendances', function($q){
                $q->where('date',date('Y-m-d'))->where('status','=','Absent & Unexcused')->groupBy('student_id');
            })->groupBy('class_id');
        }])
        ->orderBy('name','asc')->get();

    //    dd($schoolClasses->toArray());
       
        // $students = User::whereHas('roles', function ($query){
        //         $query->whereId(4);
        //     })->has('class')->groupBy('class_id')->get();

        $status = $this->getStatusValue();

        return view('admin.attendance.generate',compact('schoolClasses','selected_campus','status'));
    }

      
    public function create(Request $request){
        if($request->has('campus'))
            $selected_campus=SchoolClass::where('campus',$request->input('campus'))->first();
        else
            $selected_campus=SchoolClass::groupBy('campus')->first();

        if($request->has('class'))
            $selected_class = SchoolClass::find($request->input('class'));
        else
            $selected_class = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->first();
      
        $schoolClasses = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->get();
       
        $students = User::whereHas('roles', function ($query){
                $query->whereId(4);
            })->whereHas('class', function($query) use ($selected_class){
                 $query->where('id',$selected_class->id);
            })
        ->get();
        
        $attendances = Attendance::whereHas('students', function($q) use($selected_class){
            $q->whereHas('roles', function ($query) use($selected_class){
                    $query->whereId(4);
            })->whereHas('class', function($query) use ($selected_class){
                $query->where('id',$selected_class->id);
            });
        })
        ->whereDate('date', date('Y-m-d'))
        ->get()
        ->groupBy('student_id')
        ->map(function ($items) {
                    $arr = '';
            foreach($items as $item){
                $arr= $item->status;
            }
            return $arr;
        })
        ->toArray(); 

       // dd($attendances);

        $status = $this->getStatusValue();

        return view('admin.attendance.create',compact('schoolClasses','selected_class','selected_campus','students','status','attendances'));
    }
}
