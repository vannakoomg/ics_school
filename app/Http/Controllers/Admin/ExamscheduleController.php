<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Course;
use App\Examschedule;
use App\SchoolClass;
use Carbon\Carbon;
use App\User;
use Gate;
use App\Notifications\FirebaseNotification;
use Notification;
// use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MassDestroyCourseRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


class ExamscheduleController extends Controller
{
    
    public function index(Request $request){

        $courses = Course::orderBy('name','asc')->get();
        
        return view('admin.course.index',compact('courses'));
    }

    public function create(Request $request){
        $classes = SchoolClass::orderBy('name','asc')->get();
        $courses= Course::orderBy('name','asc')->get();
        $dayweeks = Examschedule::WEEK_DAYS;

      

        $titles = Examschedule::orderby('title','asc')->distinct()->get('title');

        $examschedules = Examschedule::select('*', DB::raw('DAYOFWEEK(date) as dayweek'))
        ->when($request->exam_title, function($q) use ($request) {
            $q->where('title','like',$request->exam_title);
        })
        ->when($request->course_filter, function($q) use ($request) {
            $q->whereHas('course', function($q) use ($request){
                $q->where('name','like',$request->course_filter);
            });
        })
        ->when($request->class_filter, function($q) use ($request) {
            $q->whereHas('class', function($q) use ($request){
                $q->where('name','like',$request->class_filter);
            });
        })->whereDate('date', '>=', date('Y-m-d',strtotime(date('Y-m-d'). ' - 0 days')));



        $examschedules = $examschedules->orderBy('date','asc')->orderBy('start_time','asc')->get();

//dd($titles);

        $current_filter = collect([
                
            'exam_title' => $request->exam_title,
            'course_filter' => $request->course_filter,
            'class_filter' => $request->class_filter,
            
         ]);


         
    //    dd($current_filter['exam_title']);

        return view('admin.exam_schedules.create',compact('classes','courses','examschedules','dayweeks','titles','current_filter'));
    }


    public function edit(Examschedule $examschedule, Request $request){
        $classes = SchoolClass::orderBy('name','asc')->get();
        $courses= Course::orderBy('name','asc')->get();
        $dayweeks = Examschedule::WEEK_DAYS;

        $titles = Examschedule::orderby('title','asc')->distinct()->get('title');

        $examschedules = Examschedule::select('*', DB::raw('DAYOFWEEK(date) as dayweek'))
        ->when($request->exam_title, function($q) use ($request) {
            $q->where('title','like',$request->exam_title);
        })
        ->when($request->course_filter, function($q) use ($request) {
            $q->whereHas('course', function($q) use ($request){
                $q->where('name','like',$request->course_filter);
            });
        })
        ->when($request->class_filter, function($q) use ($request) {
            $q->whereHas('class', function($q) use ($request){
                $q->where('name','like',$request->class_filter);
            });
        });



        $examschedules = $examschedules->orderBy('date','asc')->orderBy('start_time','asc')->get();

//dd($titles);

        $current_filter = collect([
                
            'exam_title' => $request->exam_title,
            'course_filter' => $request->course_filter,
            'class_filter' => $request->class_filter,
            
         ]);


         
    //    dd($current_filter['exam_title']);

        return view('admin.exam_schedules.edit',compact('classes','courses','examschedules','examschedule','dayweeks','titles','current_filter'));
    }


    public function store(Request $request){
        
        $request->request->add(['user_id' => Auth::user()->id]);

        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format("Y-m-d");  

        $request->merge([
            'date' => $date
        ]);

        $validated = Validator::make($request->all(),[
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'title' => 'required',
            'class_id' => 'required',
            'course_id' => 'required',
            
         ]); 

         if($validated->fails())
            return redirect()->back()->withErrors($validated)->withInput();
        
       try {    		
            $examschedule=Examschedule::create($request->except('class_id'));
            $examschedule->class()->sync($request->input('class_id',[]));

            return redirect()->route('admin.examschedule.create')->withInput();

        } catch (\Exception $exception) {
        //    return  redirect()->back()->withInput()->with('message'. $exception->getMessage());
 	      return redirect()->back()->withInput()->with('message','Duplicate data.');
                
        }

    }

    public function update(Examschedule $examschedule, Request $request){

        $request->request->add(['user_id' => Auth::user()->id]);
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format("Y-m-d");  

        $request->merge([
            'date' => $date
        ]);

        $validated = Validator::make($request->all(),[
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'title' => 'required',
            'class_id' => 'required',
            'course_id' => 'required',
            
         ]); 

    
 

         if($validated->fails())
            return redirect()->back()->withErrors($validated)->withInput();
            
        try {    		
            $examschedule->update($request->except('class_id'));
            $examschedule->class()->sync($request->input('class_id',[]));

            return redirect()->route('admin.examschedule.create')->withInput();

        } catch (\Exception $exception) {
            //"error"=>"duplicate " . $exception->getMessage()));
            return redirect()->back()->withInput()->with('message','Duplicate data.');
                
        }

    }

    public function destroy(Examschedule $examschedule){
        $examschedule->delete();

        return back()->with('message','The schedule has been deleted.');
    }



}
