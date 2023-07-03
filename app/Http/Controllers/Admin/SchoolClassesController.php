<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySchoolClassRequest;
use App\Http\Requests\StoreSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use Illuminate\Support\Facades\DB;
use App\SchoolClass;
use Gate;
use App\Elearning;
use App\Examschedule;
// use App\Lesson;
use App\Timetable;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Notify;
use App\ScheduleTemplate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchoolClassesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $campus = SchoolClass::groupBy('campus')->pluck('campus','campus');
        
        $campus_selected = request()->has('campus')?request()->campus:$campus['MC'];

       
        if(request()->has('itclass'))
            $schoolClasses = SchoolClass::where('campus',$campus_selected)->get()->sortBy('sorts')->sortBy('sorts1');
        else
            $schoolClasses = SchoolClass::whereNotIn('id',[68])->where('campus',$campus_selected)->get()->sortBy('sorts')->sortBy('sorts1');
     //   dd($schoolClasses);
        $current_filter = [
            'campus' => $campus_selected
        ];

        return view('admin.schoolClasses.index', compact('schoolClasses','campus','current_filter'));
    }



    public function create()
    {
        abort_if(Gate::denies('school_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $campuses = $this->getCampusValues();
        
        $teachers = User::whereHas('roles', function ($query) {
            $query->whereId(3);
        })->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $templates = ScheduleTemplate::oldest('name')->get()->pluck('name','id');
        $groups = $this->getGroupValues();
        return view('admin.schoolClasses.create', compact('campuses','teachers','templates','groups'));
    }

    public function store(StoreSchoolClassRequest $request)
    {

        // request()->validate([
        //    // 'name' => 'required|unique:school_classes,campus',
        //     // 'campus' => 'required|unique:school_classes,name',
        //     'name' => [
        //         'required',
        //         Rule::exists('school_classes')->where('campus', $request->campus)->where('name', $request->name)
        //     ]
        // ]);
        

        request()->validate([
            'name' => [
                        'required',
                        Rule::unique('school_classes')->where(function($q) use ($request){
                            return $q->where('campus', $request->campus);
                        })
                    ]
        ]);

        if( ScheduleTemplate::whereIn('id',$request->input('template_id', []))->where('type','Both')->first() && count($request->input('template_id', []))>1)
            return redirect()->back()->with('message','If you choose Both, please remove other type[Odd or Even]');

        $schoolClass = SchoolClass::create($request->all());

        $schoolClass->schedule_template()->sync($request->input('template_id', []));

        //Notify::success('The new class has been created.');



        return redirect()->route('admin.school-classes.index')->with('success', 'Class was successfully added!');
    }

    public function edit(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         $campuses = $this->getCampusValues();

         
         $teachers = User::whereHas('roles', function ($query) {
            $query->whereId(3);
        })->whereHas('classteacher', function($q) use($schoolClass){
            $q->where('campus',$schoolClass->campus);
        })->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $templates = ScheduleTemplate::oldest('name')->pluck('name','id');
        $groups = $this->getGroupValues();
        return view('admin.schoolClasses.edit', compact('schoolClass','campuses','teachers','templates','groups'));
    }

    public function update(SchoolClass $schoolClass, Request $request)
    {
      //  dd($schoolClass->id);
     
        request()->validate([
            'name' => [
                        'required',
                        Rule::unique('school_classes')->ignore($schoolClass->id)->where(function($q) use ($request,$schoolClass){
                            return $q->where('campus', $request->campus);
                        })
                    ]
        ]);
        // $validation  = Validator::make($request->all(),$data);

        
        // if($validation->fails())
        //     return redirect()->back()->with('message',$validation->messages());

        if( ScheduleTemplate::whereIn('id',$request->input('template_id', []))->where('type','Both')->first() && count($request->input('template_id', []))>1)
            return redirect()->back()->with('message','If you choose Both, please remove other type[Odd or Even]');

        $schoolClass->update($request->all());
        $schoolClass->schedule_template()->sync($request->input('template_id', []));

        return redirect()->route('admin.school-classes.index');
    }

    public function getteacher($campus){

        $data = User::whereHas('roles', function ($query) {
            $query->whereId(3);
        })->whereHas('classteacher', function($q) use($campus){
            $q->where('campus',$campus);
        })->get();

        return response()->json(['data'=> $data]);
    }

    public function show(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolClass->load('classLessons', 'classUsers');

        return view('admin.schoolClasses.show', compact('schoolClass'));
    }

    public function destroy(SchoolClass $schoolClass)
    {
        abort_if(Gate::denies('school_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // dd($schoolClass->classUsers->isEmpty());
        $exsist = $schoolClass->classUsers->isEmpty() && $schoolClass->examschedule->isEmpty() && $schoolClass->announcements->isEmpty() && $schoolClass->elearning->isEmpty() && $schoolClass->timetable->isEmpty();
  
        if(!$exsist)
            return redirect()->back()->with('message','Can not delete. This School Class has been do the transaction.');

        $schoolClass->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolClassRequest $request)
    {

        $schoolClass = SchoolClass::whereIn('id', request('ids'));

        // return response()->json($schoolClass, 200);

        foreach($schoolClass->get() as $class){
            
            $exsist = $class->classUsers->isEmpty() && $class->examschedule->isEmpty() && $class->announcements->isEmpty() && $class->elearning->isEmpty() && $class->timetable->isEmpty();
            if(!$exsist)
                return redirect()->back()->with('message','Can not delete. This School Class has been do the transaction.');
        }


        $schoolClass->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public static function getGroupValues() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM school_classes WHERE Field = 'level_type'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
      }

     public static function getCampusValues() {
      $type = DB::select(DB::raw("SHOW COLUMNS FROM school_classes WHERE Field = 'campus'"))[0]->Type ;
      $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));

      return $enum;
    }

}