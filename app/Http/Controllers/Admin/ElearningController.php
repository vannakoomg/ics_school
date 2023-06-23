<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Elearning;
use App\SchoolClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Model;

class ElearningController extends Controller
{
    public function create(Request $request){

        $courses= Course::orderBy('name','asc')->get();
        $classes = SchoolClass::oldest('name')->get();
        // dd($classes);
        $current_filter=[];

        $elearnings = Elearning::oldest('course_id')->oldest('lesson')
        ->when($request->course_filter, function($q) use ($request) {
            $q->whereHas('course', function($q) use ($request){
                $q->where('name','like',$request->course_filter);
            });
        })
        ->when($request->class_filter, function($q) use ($request) {
            $q->whereHas('class', function($q) use ($request){
                $q->where('name','like',$request->class_filter);
            });
        })->get();


        $current_filter = collect([
           
            'course_filter' => $request->course_filter,
            'class_filter' => $request->class_filter,
            
         ]);

        return view('admin.elearning.create' , compact('courses','current_filter','elearnings','classes','current_filter'));
    }


    public function edit(Elearning $elearning, Request $request){

        $courses= Course::orderBy('name','asc')->get();
        $classes = SchoolClass::oldest('name')->get();
        $current_filter=[];
        $elearnings = Elearning::oldest('course_id')->oldest('lesson')->get();
        return view('admin.elearning.edit' , compact('courses','current_filter','elearnings','elearning','classes'));
    }


    public function store(Request $request){

         $request->request->add(['user_id' => Auth::user()->id,'active'=>1]);

       //  dd($request->all());

        //$date = Carbon::createFromFormat('d/m/Y', $request->date)->format("Y-m-d");  

        $request->merge([
            'category' => ($request->category == 'on') ? 'Video':'Document'
        ]);

        $validated = Validator::make($request->all(),[
            'course_id' => 'required|unique:elearning,course_id,NULL,id,lesson,' . $request->lesson . ',category,' .  $request->category,
            'lesson' => 'required',
            'description' => 'required',
            'url' => 'required',
            'category' => 'required',
            
         ]); 

         if($validated->fails())
            return redirect()->back()->withErrors($validated)->withInput();
        
        try {    		
            $elearning=Elearning::create($request->except('class_id'));
           $elearning->class()->sync($request->input('class_id',[]));
           

            return redirect()->route('admin.elearning.create')->withInput($request->except('lesson','description','url'));
        } catch (\Exception $exception) {
            //"error"=>"duplicate " . $exception->getMessage()));
            return redirect()->back()->withInput()->with('message','Duplicate data.');
        }          
    }

    public function changestatus(Elearning $elearning, Request $request){
        $elearning->update(['active'=> ($elearning->active==1)?0:1 ]);
        return redirect()->route('admin.elearning.create')->with('message','Changed Status is successful.');
    }

    public function update(Elearning $elearning, Request $request){

        $request->request->add(['user_id' => Auth::user()->id,'active'=>$elearning->active]);

      //  dd($request->all());

       //$date = Carbon::createFromFormat('d/m/Y', $request->date)->format("Y-m-d");  

       $request->merge([
           'category' => ($request->category == 'on') ? 'Video':'Document'
       ]);

       $validated = Validator::make($request->all(),[
           'course_id' => 'required|unique:elearning,course_id,' . $elearning->id . ',id,lesson,' . $request->lesson . ',category,' .  $request->category,
           'lesson' => 'required',
           'description' => 'required',
           'url' => 'required',
           'category' => 'required',
           
        ]); 

        if($validated->fails())
           return redirect()->back()->withErrors($validated)->withInput();
       
       try {    		
            $elearning->update($request->except('class_id'));
            $elearning->class()->sync($request->input('class_id',[]));

           return redirect()->route('admin.elearning.create')->with('message','Updated is successful.');

       } catch (\Exception $exception) {
           //"error"=>"duplicate " . $exception->getMessage()));
           return redirect()->back()->withInput()->with('message','Duplicate data.');
       }          
   }


   public function destroy(Elearning $elearning)
   {
      // abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       $elearning->delete();

       return back();
   }

}