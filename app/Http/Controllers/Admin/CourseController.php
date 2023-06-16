<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Course;
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

class CourseController extends Controller
{
    public $colors = ['#7bd148','#5484ed','#a4bdfc','#46d6db','#7ae7bf','#51b749','#fbd75b','#ffb878','#dc2127','#dbadff','#e1e1e1','#ffffff'];
    
    private  $categories = ['Primary-Kindergarten','Secondary'];
    
    public function index(Request $request){

       
        $categories = $this->categories;
// dd($request->filter_language);
        $languages = $this->getLanguageValues();
        $languages=Arr::prepend($languages,'All');
        $current_filter['category'] = $request->has('filter_category') ? $request->filter_category: $categories[0];
        $current_filter['language'] = $request->has('filter_language') ? $request->filter_language: $languages[0];
       // dd($request->filter_category);

    $courses = Course::when($current_filter['category'] , function($q) use($current_filter){
        $q->where('category',$current_filter['category']);
    })->when($current_filter['language'], function($q) use($current_filter){
        if($current_filter['language']!='All')
            $q->where('language',$current_filter['language']);
    })->orderBy('language','asc')->orderBy('name','asc')->get();

        return view('admin.course.index',compact('courses','categories','current_filter','languages'));
    }

    public function show(Feedback $feedback){

        return view('admin.feedback.show',compact('feedback'));
    }


    public function create(){

        $classes = SchoolClass::select(DB::raw("CONCAT(name,'-', campus) as newname"),'id')->get()->pluck('newname', 'id');
        $colors = $this->colors;
        
        //$categories = $this->getGroupValues();
        $categories = $this->categories;
        $primary = SchoolClass::where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten = SchoolClass::where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary = SchoolClass::where('level_type','Secondary')->pluck('id')->toArray();

        $filter = [
            'primary-kindergarten' => array_merge($primary,$kindergarten),
           // 'kindergarten' => $kindergarten,
            'secondary' => $secondary,
        ];

        $languages=$this->getLanguageValues();


        return view('admin.course.create',compact('classes','colors','categories','filter','languages'));
    }

    public function edit(Course $course){
        $classes = SchoolClass::select(DB::raw("CONCAT(name,'-', campus) as newname"),'id')->get()->pluck('newname', 'id');
        $categories = $this->categories;
        $colors = $this->colors;
        $languages=$this->getLanguageValues();

        $primary = SchoolClass::where('level_type','Primary')->pluck('id')->toArray();
        $kindergarten = SchoolClass::where('level_type','Kindergarten')->pluck('id')->toArray();
        $secondary = SchoolClass::where('level_type','Secondary')->pluck('id')->toArray();

        $filter = [
            'primary-kindergarten' => array_merge($primary,$kindergarten),
           // 'kindergarten' => $kindergarten,
            'secondary' => $secondary,
        ];

        return view('admin.course.edit',compact('course','classes','colors','categories','languages','filter'));
    }

    public function update(Course $course, Request $request){

        // $data=[
        //     'name'=>'required|unique:course,name,'.$course->id,
        //     'imgupload' =>  empty($course->image) ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048':'',
        // ];

        // $validation  = Validator::make($request->all(),$data);

        
        // if($validation->fails())
        //     return redirect()->back()->with('message',$validation->messages());

        request()->validate([
            'name' => [
                        'required',
                        Rule::unique('course')->ignore($course->id)->where(function($q) use ($request,$course){
                            return $q->where('category', $request->category);
                        })
                    ],
            'imgupload' =>  empty($course->image) ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048':''        
        ]);

        $fileName = $course->image;

        if ($files = $request->file('imgupload')) {

            Storage::delete(['image/' . $course->image]);
            $fileName =  "image-".time().'.'.$request->imgupload->getClientOriginalExtension();
            $request->imgupload->storeAs('image', $fileName);
        }    

        $data = [
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $fileName,
            'color' => $request->color ?? '',
            'category' => $request->category,
            'language' => $request->language,
        ];

        $course->update($data);    
        $course->class()->sync($request->input('class_id', []));

        return redirect()->route('admin.course.index')->with('message','The Course has been update.');

    }

    public function store(Request $request){

        
         request()->validate([
            'name' => [
                'required',
                Rule::unique('course')->where(function($q) use ($request){
                    return $q->where('category', $request->category);
                })
            ],
            'imgupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

        if ($files = $request->file('imgupload')) {
            $fileName =  "image-".time().'.'.$request->imgupload->getClientOriginalExtension();
            $request->imgupload->storeAs('image', $fileName);
        }  

         $data = [
             'user_id' => Auth::user()->id,
             'name' => $request->name,
             'description' => $request->description,
             'color' => $request->color ?? '',
             'category' => $request->category,
             'language' => $request->language,
            'image' => $fileName            
         ];
         
         
         $fileName = '';


        $course=Course::create($data);

        $course->class()->sync($request->input('class_id', []));

        return redirect()->route('admin.course.create')->with('message','The course has been created.');
        
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

     //   dd($course->has_timetables());
        // dd($course->examschedules->isEmpty());
    //  dd(!$course->has_timetables());

        $exsist = $course->examschedules->isEmpty()  && $course->elearnings->isEmpty() && !$course->has_timetables();
       
        if(!$exsist)
            return redirect()->back()->with('message','Can not delete. This Course has been do the transaction.');


        if(!empty($course->image))
            Storage::delete(['image/' . $course->image]);

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        $courses = Course::whereIn('id', request('ids'));

       
        foreach($courses->get() as $course){     
      
            $exsist = $course->examschedules->isEmpty() && $course->elearnings->isEmpty() && !$course->has_timetables();

            if(!$exsist)
                return redirect()->back()->with('message','Can not delete. This Course has been do the transaction.');
        }

        $courses->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public static function getCampusValues() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM school_classes WHERE Field = 'campus'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
      }

      public static function getGroupValues() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM school_classes WHERE Field = 'level_type'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
      }

      public static function getLanguageValues() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM course WHERE Field = 'language'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
  
        return $enum;
      }


}
