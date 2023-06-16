<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimetableRequest;
use App\Http\Requests\StoreTimetableRequest;
use App\Http\Requests\UpdateTimetableRequest;
use App\Lesson;
use App\SchoolClass;
use App\User;
use App\Course;
use App\ScheduleTemplate;
use App\ScheduleTemplateDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CalendarService;
use Illuminate\Support\Facades\DB;
use App\Timetable;
use Carbon\Carbon;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class TimetablesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::all();

        return view('admin.lessons.index', compact('lessons'));
    }

    public function exporttimetable(Request $request){

        $campus = SchoolClass::groupBy('campus')->pluck('campus','campus'); //->prepend(trans('global.pleaseSelect'), '');

        //$campus_selected = request()->has('campus')?request()->campus:$campus['MC'];

    
       // dd(array_search($classes->first(), $classes->toArray()));
 
       // $class_selected =  array_search($classes->first(), $classes->toArray()); //request()->has('class_id')?request()->class_id:
        $allclasses = SchoolClass::has('schedule_template')->get();

        $classes = SchoolClass::has('schedule_template')->with('schedule_template')->whereIn('id',$request->input('class_id',[]))
        ->get();

        // dd($classes);
        $timetables=[];

        foreach($classes as $class){
            $timetables[$class->id]['class']=$class;
            $timetables[$class->id]['class']['khmerteacher']=$class->khmerteacher;
            $timetables[$class->id]['class']['teacheraide']=$class->teacheraide;

            foreach($class->schedule_template as $template){
                // if(!key_exists('timetables',$timetables[$class->id]))
                //         $timetables[$class->id]['timetables'][$template->id] = [];  
                // $timetables[$class->id]['timetables'][$template->id][]=Timetable::whereHas('template_detail', function($q) use($template){
                //     $q->where('school_template_id',$template->id);
                // })->where('class_id',$class->id)->get()->map(function($timetable){
                //     $timetable->times = $timetable->template_detail->time;
                //     $timetable->teachername = $timetable->teacher_name;
                //     $timetable->monday = $timetable->getcourse('monday') . '<br/>' . $timetable->getteacher('monday') ;
                //     $timetable->tuesday = $timetable->getcourse('tuesday') . '<br/>' . $timetable->getteacher('tuesday') ;
                //     $timetable->wednesday = $timetable->getcourse('wednesday') . '<br/>' . $timetable->getteacher('wednesday') ;
                //     $timetable->thursday = $timetable->getcourse('thursday') . '<br/>' . $timetable->getteacher('thursday') ;
                //     $timetable->friday = $timetable->getcourse('friday') . '<br/>' . $timetable->getteacher('friday') ;
                    

                //     return $timetable;
                // });

    $schedule_template = $class->schedule_template->where('type',$template->type)->first();
    
    $timetables1 = ScheduleTemplateDetail::select('id','school_template_id','start_time','end_time','breaktime',DB::raw('"" as monday,"" as tuesday, "" as wednesday,"" as thursday,"" as friday,"" as saturday'))
    ->whereHas('scheduletemplate', function($q) use($template, $class){
        $q->whereHas('school_class', function($q) use($class) {
            $q->where('class_id',$class->id);
        })->where('type',$template->type)->where('breaktime','!=','Study Time');
    });

     // return response()->json($timetables1->get());

      $timetables[$class->id]['timetables'][$template->type] =  Timetable::rightjoin('schedule_template_detail','timetable.template_detail_id','=','schedule_template_detail.id')
      ->join("schedule_template","schedule_template_detail.school_template_id","=","schedule_template.id")
      ->select('schedule_template_detail.id','school_template_id','start_time','end_time','schedule_template_detail.breaktime', 'timetable.monday','tuesday','wednesday','thursday','friday','saturday')
      ->where('type',$template->type)
      ->where('schedule_template_detail.breaktime','Study Time')
      ->where('class_id',$class->id)
      ->where('timetable.template_id', $schedule_template->pivot->schedule_template_id ?? 0)
    // ->where('timetable.template_id',
     ->union($timetables1)
      ->orderBy('start_time','asc')->get()->map(function($timetable){
          
          $timetable->teachername = $timetable->teacher_name;
          $timetable->monday = $timetable->getcourse('monday') . '<br/>' . $timetable->getteacher('monday') ;
          $timetable->tuesday = $timetable->getcourse('tuesday') . '<br/>' . $timetable->getteacher('tuesday') ;
          $timetable->wednesday = $timetable->getcourse('wednesday') . '<br/>' . $timetable->getteacher('wednesday') ;
          $timetable->thursday = $timetable->getcourse('thursday') . '<br/>' . $timetable->getteacher('thursday') ;
          $timetable->friday = $timetable->getcourse('friday') . '<br/>' . $timetable->getteacher('friday') ;
          $timetable->saturday = $timetable->getcourse('saturday') . '<br/>' . $timetable->getteacher('saturday') ;
         // $timetable->breaktime = $timetable->break
          return $timetable;
      });
                
            // $timetables[$class->id]['timetables'][$template->type] = Timetable::rightjoin('schedule_template_detail','timetable.template_detail_id','=','schedule_template_detail.id')
            // ->join("schedule_template","schedule_template_detail.school_template_id","=","schedule_template.id")
            // ->select(['schedule_template_detail.*','schedule_template_detail.breaktime as breaktime','timetable.*'])
            // ->where('schedule_template.type', $template->type)->where(function($q) use($class) {
            //         $q->where('timetable.class_id', $class->id)->orWhereNull('timetable.class_id');
            // })
            // ->orderBy('schedule_template_detail.start_time')->get()->map(function($timetable){
                
            //     $timetable->teachername = $timetable->teacher_name;
            //     $timetable->monday = $timetable->getcourse('monday') . '<br/>' . $timetable->getteacher('monday') ;
            //     $timetable->tuesday = $timetable->getcourse('tuesday') . '<br/>' . $timetable->getteacher('tuesday') ;
            //     $timetable->wednesday = $timetable->getcourse('wednesday') . '<br/>' . $timetable->getteacher('wednesday') ;
            //     $timetable->thursday = $timetable->getcourse('thursday') . '<br/>' . $timetable->getteacher('thursday') ;
            //     $timetable->friday = $timetable->getcourse('friday') . '<br/>' . $timetable->getteacher('friday') ;
            //    // $timetable->breaktime = $timetable->break
            //     return $timetable;
            // });
        
            }
        }

        $timetables = json_decode(json_encode($timetables));        
    //   dd($timetables);
        
        if(strtolower($request->btn_submit)=='preview' || empty($request->btn_submit))
            return view('admin.lessons.exporttimetable', compact('timetables','campus','allclasses','classes'));
        else{
            $view = \View::make('admin.lessons.exporttimetable', compact('timetables','campus','allclasses','classes'));
            $htm = $view->render();

            $pdf = PDF::loadHTML($htm);
            return $pdf->download('timetable.pdf');
        }
       

    //     $timetables = Timetable::oldest('start_time')->where('class_id',$class_id)->get();
    //     $class = SchoolClass::find($class_id);

    //     // $path = Storage::disk('local')->path("timetable.pdf");
    //     // $view = \View::make('admin.lessons.exporttimetable', compact('timetables','class'));
    //     // $html = $view->render();

    //     // $mpdf = new Mpdf(['default_font' => 'Khmer OS','mode'=> 'UTF-8', 'format' => 'A4-L' , 'autoScriptToLand'=>true, 'autoLangToFont'=>true]);

    //     // $mpdf->writeHTML($view);    
    //     // $mpdf->Output();


    //     // $pdf = PDF::loadView('admin.lessons.exporttimetable', ['timetables'=>$timetables,'class'=>$class]); //->setPaper('a4', 'landscape')
    //     // $html = mb_convert_encoding(\View::make('admin.lessons.exporttimetable', compact('timetables','class')),'HTML-ENTITIES','UTF-8');
    //   //  $pdf = PDF::loadViewl('admin.lessons.exporttimetable', compact('timetables','class'))->setPaper('a4', 'landscape');
    //    // $pdf = PDF::loadHTML('<p style="font-family:khmerosmoulpali">This  សាលារៀន!</p>');

    //      $view = \View::make('admin.lessons.exporttimetable', compact('timetables','class'));
    //      $htm = $view->render();
    //      $pdf = PDF::loadHTML($htm);
        //  return $pdf->download('timetable.pdf');

        //return $pdf->download('timetable.pdf');

    //      return view('admin.lessons.exporttimetable', compact('timetables','class'));

    }

    public function create(CalendarService $calendarService)
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $campus = SchoolClass::groupBy('campus')->pluck('campus','campus'); //->prepend(trans('global.pleaseSelect'), '');

        $campus_selected = request()->has('campus')?request()->campus:$campus['MC'];

    //    dd(request()->all());
        $classes = SchoolClass::where('campus', $campus_selected)->pluck('name', 'id');  //->prepend(trans('global.pleaseSelect'), '');
     
       // dd(array_search($classes->first(), $classes->toArray()));
        if(in_array(request()->class_id, array_keys($classes->toArray())))
            $class_selected = request()->class_id;
        else
            $class_selected =  array_search($classes->first(), $classes->toArray()); //request()->has('class_id')?request()->class_id:
        

        $courses = Course::whereHas('class',function($q) use($class_selected) {
            $q->where('class_id',$class_selected);
        })->oldest('name')->get();

        // $weekDays     = Lesson::WEEK_DAYS;
        // $calendarData = $calendarService->generateCalendarData($weekDays);
        $templates = ScheduleTemplate::whereHas('school_class', function($q) use($class_selected){
            $q->where('class_id', $class_selected);
        })
        ->oldest('name')->get()->pluck('name','id');
        
       
        $timetables = Timetable::all(); //->where('class_id',$class_selected)->get();

      //  dd(key($templates));

        $template_selected = request()->has('template_id')?request()->template_id: key($templates->toArray());

        $teachers = User::whereHas('roles', function($q){
                $q->where('id',3);  
        })->whereHas('classteacher',function($q) use($class_selected) {
                $q->where('class_id',$class_selected);
        })->pluck('name', 'id');

        $scheduletemplatedetails = ScheduleTemplateDetail::with(['timetable.class' => function($q) use($class_selected){
            //    $q->whereHas('timetable', function($q) use($class_selected) {
            //         $q->where('class_id',1);
            // });
        }])
        ->where('school_template_id',$template_selected)
       
        ->oldest('start_time')->get();

      //  dd($scheduletemplatedetails);
        $current_filter = [
                    'campus' => $campus_selected,
                    'class_id' => $class_selected,
                    'class_name' => $classes[$class_selected],
                    'template_id' => $template_selected,
                ];

        $cuurent_class = SchoolClass::find($class_selected);

        return view('admin.lessons.create', compact('classes', 'teachers','timetables','courses','campus','current_filter','templates','scheduletemplatedetails','cuurent_class'));
    }


    public function updatetimetable(Request $request,$template_detail_id){

       // return response()->json(['data'=>$template_detail_id]);

        if($request->has('column_name') && $request->has('item') && $request->has('value')){

            $timetable = Timetable::where('template_detail_id',$template_detail_id)->where('template_id', $request->template_id)->where('class_id',$request->class_id)->first();

            $arr_template_detail = ScheduleTemplateDetail::find($template_detail_id);
            if($timetable)
                $data = json_decode($timetable->{$request->column_name}, true);

                

            if($request->item=='teacher'){
                $data['teacher']=$request->value;
              
                $validate = Timetable::whereHas('template_detail', function($q) use($arr_template_detail) {
                                $q->whereTime('start_time', '>=', Carbon::parse($arr_template_detail->start_time)->format('H:i:s'))->whereTime('end_time', '<=', Carbon::parse($arr_template_detail->end_time)->format('H:i:s'));
                            })
                            ->where($request->column_name,'LIKE','%"teacher":"' . $request->value . '"%')
                            ->first();
                       
               // return response()->json($validate->toSql());
                if($validate){
                    $teacher_name = User::find($request->value)->name;
                    return response()->json(["status"=>false,'data' => ['message'=>'Teacher named "' . $teacher_name . '" has been assigned to another class for Time: ' . $arr_template_detail->time]], Response::HTTP_OK);
                }
            }else if($request->item=='course'){
                
                $data['course']=$request->value;
               
            }
            
            Timetable::updateOrCreate([
                'class_id'=>$request->class_id, 'template_id' => $request->template_id,'template_detail_id'=> $template_detail_id
            ],['class_id'=>$request->class_id, 'template_id' => $request->template_id,'template_detail_id'=> $template_detail_id, $request->column_name => json_encode($data)]);
        
            return response()->json(["status"=>true,'data' => $data], Response::HTTP_OK);

        }

        return response()->json(['status'=>false, 'data' => $request->column_name], 200);
    }

    public function removetimetable(Request $request,$template_detail_id){

        if($request->has('column_name') && $request->has('item') && $request->has('value')){

            $timetable = Timetable::where('template_detail_id',$template_detail_id)->where('template_id', $request->template_id)->where('class_id',$request->class_id);

            $data = json_decode($timetable->first()->{$request->column_name}, true);  

            if($request->item=='teacher')
                unset($data['teacher']);
            else if($request->item=='course')
                unset($data['course']);

            $timetable->update([$request->column_name => $data]);

            return response()->json(["status"=>true,'data' => $data ], Response::HTTP_OK);

        }

        return response()->json(['status'=>false, 'data' => $request->column_name], 200);
    }

    public function store(StoreTimetableRequest $request)
    {
        $lesson = Timetable::create($request->all());

        return redirect()->route('admin.timetable.create',['campus'=>$request->campus, 'class_id'=> $request->class_id]);

        // return redirect()->route('admin.lessons.create')->withInput();
    }

    public function edit(Timetable $timetable)
    {
        abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //$teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //$lesson->load('class'); // 'teacher'

        return view('admin.lessons.edit', compact('classes', 'timetable'));
    }

    public function update(UpdateTimetableRequest $request, Timetable $timetable)
    {
        if(!empty($request->breaktime))
                $request->request->add([
                    'monday'=>'',
                    'tuesday'=>'',
                    'wednesday'=>'',
                    'thursday'=>'',
                    'friday'=>'',
                    'saturday'=>''
                ]);

        $timetable->update($request->all());

        return redirect()->route('admin.timetable.create',['campus'=>$request->campus, 'class_id'=> $request->class_id]);
    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->load('class', 'teacher');

        return view('admin.lessons.show', compact('lesson'));
    }

    public function destroy(Timetable $timetable)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timetable->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimetableRequest $request)
    {
        Timetable::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
