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
use App\ScheduleTemplate;
use App\ScheduleTemplateDetail;
use Illuminate\Support\Facades\Validator;

class ScheduleTemplateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $scheduletemplates = ScheduleTemplate::orderBy('name','asc')->get();
       
        // dd($scheduletemplatedetail);
        return view('admin.scheduletemplate.index', compact('scheduletemplates'));
    }

    

    private static function getBreaktimes() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM schedule_template_detail WHERE Field = 'breaktime'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
    }

    private static function getTypeValue() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM schedule_template WHERE Field = 'type'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
    }

    public function create(){

        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $types = $this->getTypeValue();

        return view('admin.scheduletemplate.create', compact('types'));

    }

    public function edit(ScheduleTemplate $scheduletemplate){

        abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $types = $this->getTypeValue();

        return view('admin.scheduletemplate.edit', compact('scheduletemplate','types'));

    }


    public function update(ScheduleTemplate $scheduletemplate, Request $request){

       // abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       $data=[
        'name'=>'required|unique:schedule_template,name,'.$scheduletemplate->id,
       ];

    $validation  = Validator::make($request->all(),$data);

    
    if($validation->fails())
        return redirect()->back()->with('message',$validation->messages());

        $scheduletemplate->update($request->all());
        return redirect()->route('admin.scheduletemplate.index');

    }

    public function store(Request $request){

        $request->merge([
            'user_id' => auth()->user()->id
        ]);

        request()->validate([
            'name' => 'required|unique:schedule_template,name',
         ]);


        $scheduletemplate = ScheduleTemplate::create($request->all());

        return redirect()->route('admin.scheduletemplate.detail',[$scheduletemplate->id]);
    }

    public function templatedetail(Request $request, ScheduleTemplate $scheduletemplate){

        $scheduletemplatedetails = ScheduleTemplateDetail::where('school_template_id', $scheduletemplate->id)->orderBy('start_time','asc')->get();
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday']; 
        $breaktimes = $this->getBreaktimes();
        // dd($scheduletemplatedetail);
        return view('admin.scheduletemplate.templatedetail', compact('scheduletemplate','scheduletemplatedetails','days','breaktimes'));
    }


    public function templatedetailcreate(Request $request){

        $scheduletemplate=ScheduleTemplate::find($request->template_id);
        if($scheduletemplate)
            $scheduletemplate->detail()->create($request->all());
        else
            return redirect()->back();

        return redirect()->route('admin.scheduletemplate.detail',[$scheduletemplate->id]);
    }

    public function templatedetailedit(ScheduleTemplateDetail $scheduletemplatedetail, Request $request){
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday']; 
        
        $scheduletemplate = $scheduletemplatedetail->scheduletemplate;
        $scheduletemplatedetails = ScheduleTemplateDetail::where('school_template_id', $scheduletemplate->id)->orderBy('start_time','asc')->get();
        // dd($scheduletemplate);
        $breaktimes = $this->getBreaktimes();
        return view('admin.scheduletemplate.templatedetail', compact('scheduletemplate','scheduletemplatedetail','scheduletemplatedetails','days','breaktimes'));
    }

    public function templatedetailupdate(ScheduleTemplateDetail $scheduletemplatedetail, Request $request){
        // dd($scheduletemplatedetail);
        $timetable_studytime = Timetable::where('template_detail_id', $scheduletemplatedetail->id)->count();
        if($request->breaktime!='Study Time' && $timetable_studytime>0)
		Timetable::where('template_detail_id', $scheduletemplatedetail->id)->delete();
        $scheduletemplatedetail->update($request->all());
        
        $scheduletemplate = $scheduletemplatedetail->scheduletemplate;
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday']; 
        $scheduletemplatedetails = ScheduleTemplateDetail::where('school_template_id', $scheduletemplate->id)->orderBy('start_time','asc')->get();
        return redirect()->route('admin.scheduletemplate.detail',[$scheduletemplate->id])->with(compact('scheduletemplate','scheduletemplatedetails','days'));
    }

    public function templatedetaildelete(ScheduleTemplateDetail $scheduletemplatedetail)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

     //   if($scheduletemplatedetail->timetable()->count()>0)
       //      return back()->with('message','You cannot delete. Cos Its already attach with class timetable.');
        $scheduletemplatedetail->timetable()->delete();
        $scheduletemplatedetail->delete();

        return back();
    }

    public function destroy(ScheduleTemplate $scheduletemplate)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($scheduletemplate->school_class()->count()>0)
            return back()->with('message','You cannot delete. Cos Its already attach with Timetable.');
            
        $scheduletemplate->detail()->delete();
        $scheduletemplate->delete();

        return back();
    }

}
