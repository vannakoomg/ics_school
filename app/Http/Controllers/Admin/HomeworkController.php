<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\FirebaseNotification;
use Notification;
use App\User;
use App\Attendance;
use App\SchoolClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Course;
use App\Homework;
use App\HomeworkAttachment;
use App\HomeworkResult;
use App\HomeworkResultAttachment;
use DataTables;
use Storage;
use Session;

class HomeworkController extends Controller {

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
    // $type = DB::select(DB::raw("SHOW COLUMNS FROM course WHERE Field = 'language'"))[0]->Type ;
    // $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
    
    $laguages = auth()->user()->courseteacher()->groupBy('language')->pluck('language')->toArray();

    return $laguages;
    }
    
    public static function getTermValues() {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM homework WHERE Field = 'term'"))[0]->Type ;
        $enum=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $type));
    
        return $enum;
        }

    public function create(Request $request){
        $classes = User::find(auth()->user()->id)->classteacher()->get();

       // dd($classes);
        $groups = $this->getGroupValues();
        $campuses = $this->getCampusValues();

        $languages = $this->getLanguageValues();
       // if(empty($request->language)) 
         //   $request->merge(array('langauge'=>$languages[0]));
           // dd($languages[0]);
        if(count($languages)>0){   
        $courses = Course::where('language',$languages[0])->whereHas('class',function($q) use($classes){
            if(count($classes)>0)
                $q->where('class_id',$classes[0]->id);
        })->oldest('name')->get();
        }else{
            $courses=[];
        }
        $terms = $this->getTermValues();
        // whereHas('class',function($q) use($class_selected) {
        //     $q->where('class_id',$class_selected);
        // })
            // dd($courses);
        return view('admin.homework.create', compact('classes','groups','campuses','courses','languages','terms'));
    }

    public function updateimgae(Request $request){
        if($request->ajax()){
            $imageFile = $_FILES['imageFile'];
            
           // return response()->json($request->file('imageFile'));

            $filename = $request->imageName;
            
            $editedImage = file_get_contents($imageFile['tmp_name']);
            file_put_contents($filename, $editedImage);
            $path = Storage::path('docs/');
            // $filename->storeAs('docs',$filename);
            move_uploaded_file($imageFile['tmp_name'], $path.$filename);


            $homework_result_attachment = HomeworkResultAttachment::find($request->trid);
            if(!strstr($homework_result_attachment->filename ,'(Edited)')){
                $homework_result_attachment->filename = "(Edited)-" . $homework_result_attachment->filename;
                $homework_result_attachment->save();
            }
            // $arr_data=new HomeworkAttachment([
            //     'filename' => pathinfo($imageFile)['filename'],
            //     'path' =>  $path
            // ]);
            // // 
            // $homework->attachments()->save($arr_data);

            return response()->json(['status'=>'success','data'=>$imageFile, 'filename'=>$homework_result_attachment->filename]);
        }
    }

    public function edit(Homework $homework , Request $request){
        $classes = User::find(auth()->user()->id)->classteacher()->get();

        // dd($homework);

        $groups = $this->getGroupValues();
        $campuses = $this->getCampusValues();

        $languages = $this->getLanguageValues();
        $terms = $this->getTermValues();
        $courses = Course::whereHas('class', function($q) use($homework){
                $q->where('class_id',$homework->class_id);
        })->where('language',$homework->language)->oldest('name')->get();

        return view('admin.homework.edit', compact('classes','groups','campuses','courses','languages','homework','terms'));
    }

    // public function homeworkDetail(Request $request){
    //     if($request->ajax()){
    //         $homework_result = HomeworkResult::find($request->trid);
    //         $data=[
    //             'data'=> $homework_result,
    //             'status' => 'success'
    //         ];
    //         return response()->json($data, 200);
    //     }
    // }


    public function show(Homework $homework , Request $request){

        if($homework->submitted==0)
            return redirect()->route('admin.homework.index')->with('message','This Assignment is not submit. So you cannot provide score to student.');
        
        $classes = User::find(auth()->user()->id)->classteacher()->get();


        // dd($homework);

        $groups = $this->getGroupValues();
        $campuses = $this->getCampusValues();

        $languages = $this->getLanguageValues();
        
        // $students = User::whereHas('roles', function($q){
        //     $q->whereId(4);
        // })->whereHas('class', function($q) use($homework) {
        //     $q->where('class_id',$homework->class_id);
        //  })
        //  ->whereHas('result', function($q) use ($homework){
        //     $q->where('turnedin',1)->where('homework_id',$homework->id);
        // })
        // // ->with(['result'=>function($q) use ($homework{
        // //     $q->where('turnedin',1)->where('homework_id',$homework->id)->orderBy('turnedindate','desc');
        // // }])
        // ->get();

        $students = HomeworkResult::where('homework_id',$homework->id)->orderBy('turnedin','desc')->orderBy('turnedindate','asc')->get();

       // dd($students);
        //$homework_result = $homework->homework
        $viewonly=0;
        $courses = Course::whereHas('class', function($q) use($homework){
                $q->where('class_id',$homework->class_id);
        })->where('language',$homework->language)->oldest('name')->get();

        return view('admin.homework.show', compact('classes','groups','campuses','courses','languages','homework','students','viewonly'));
    }

    public function view(Homework $homework , Request $request){

        if($homework->submitted==0)
            return redirect()->route('admin.homework.index')->with('message','This Assignment is not submit. So you cannot provide score to student.');
        
        $classes = User::find(auth()->user()->id)->classteacher()->get();


        // dd($homework);

        $groups = $this->getGroupValues();
        $campuses = $this->getCampusValues();

        $languages = $this->getLanguageValues();
        
        // $students = User::whereHas('roles', function($q){
        //     $q->whereId(4);
        // })->whereHas('class', function($q) use($homework) {
        //     $q->where('class_id',$homework->class_id);
        //  })
        //  ->whereHas('result', function($q) use ($homework){
        //     $q->where('turnedin',1)->where('homework_id',$homework->id);
        // })
        // // ->with(['result'=>function($q) use ($homework{
        // //     $q->where('turnedin',1)->where('homework_id',$homework->id)->orderBy('turnedindate','desc');
        // // }])
        // ->get();

        $students = HomeworkResult::where('homework_id',$homework->id)->orderBy('turnedin','desc')->orderBy('turnedindate','asc')->get();

       // dd($students);
        //$homework_result = $homework->homework

        $courses = Course::whereHas('class', function($q) use($homework){
                $q->where('class_id',$homework->class_id);
        })->where('language',$homework->language)->oldest('name')->get();
        $viewonly=1;

        return view('admin.homework.show', compact('classes','groups','campuses','courses','languages','homework','students','viewonly'));
    }

    public function index(Request $request){
        $homeworks = Homework::orderBy('created_at','desc')->get();

        $terms = $this->getTermValues();

        $classes = User::find(auth()->user()->id)->classteacher()->pluck('school_classes.name','school_classes.id')->prepend(trans('global.pleaseSelect'), '');
     
        $languages=$this->getLanguageValues();
        //dd($languages);
        array_unshift($languages,trans('global.pleaseSelect'));
        //  dd($request->filter_language);
        $courses = Course::whereHas('class', function($q) use($request){
            if($request->filter_class>0)
                $q->where('class_id',$request->filter_class);
         })->when($request->filter_language, function($q) use ($request){
            if($request->filter_language != trans('global.pleaseSelect'))
                $q->where('language',$request->filter_language);
         })->oldest('name')->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
         
        $statuses = ['Published','Unpublished'];
        
        $current_filter=[
            'class' => $request->filter_class,
            'language' => $request->filter_language,
            'course' =>  $request->filter_course,
            'term' => empty($request->filter_term)?$terms[0]:$request->filter_term,
            'status' => empty($request->filter_status) ? 'Published':$request->filter_status,
        ];

        return view('admin.homework.index', compact('homeworks','classes','languages','courses','terms','current_filter','statuses'));
    }

    public function completed(Request $request){
        $homeworks = Homework::orderBy('created_at','desc')->get();

        $terms = $this->getTermValues();

        $classes = User::find(auth()->user()->id)->classteacher()->pluck('school_classes.name','school_classes.id')->prepend(trans('global.pleaseSelect'), '');
     
        $languages=$this->getLanguageValues();
        array_unshift($languages,trans('global.pleaseSelect'));
        //  dd($request->filter_language);
        $courses = Course::whereHas('class', function($q) use($request){
            if($request->filter_class>0)
                $q->where('class_id',$request->filter_class);
         })->when($request->filter_language, function($q) use ($request){
            if($request->filter_language != trans('global.pleaseSelect'))
                $q->where('language',$request->filter_language);
         })->oldest('name')->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
         

        $current_filter=[
            'class' => $request->filter_class,
            'language' => $request->filter_language,
            'course' =>  $request->filter_course,
            'term' => empty($request->filter_term)?$terms[0]:$request->filter_term,
            'status'=>-1,
        ];
        return view('admin.homework.completed', compact('homeworks','classes','languages','courses','terms','current_filter'));
    }


    public function homeworkDetail(Request $request){
        if($request->ajax()){
            $homework_result=HomeworkResult::find($request->trid);
            //return response()->json($homework_result->attachments);
            

            $attachments = '';

            foreach($homework_result->attachments as $attachment){
            $homework_result = HomeworkResult::find($request->trid);
            $pathinfo = pathinfo(storage_path() . $attachment->path);



            $ext = $pathinfo['extension'];

            $data=[
                'data'=> $homework_result,
                'status' => 'success'
            ];
                $attachments .='<li class="list-group-item image-to-edit"><a data-id="' . $attachment->id . '" data-type="' . $ext . '" target="blank" href="' . $attachment->link . '" title="Attachment Date: ' . $attachment->created_at->format('d-M-Y') . '">' . $attachment->filename . '</a></li>';
                // $attachments .='<li class="list-group-item"><img data-id="'. $attachment->id . '" src="' . $attachment->link . '"/></li>';
            }

            $html ='<div class="row">
            <div class="col">
                <label class="align-middle col-form-label font-weight-bold">Student Name: <span class="font-weight-normal">' . $homework_result->student->name . '</span></label>
            </div>
            </div>
            <div class="row">
            <div class="col align-items-right">
                <label class="align-middle col-form-label font-weight-bold">Student ID: <span class="font-weight-normal">' . $homework_result->student->email  . '</span></label>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label class="align-middle col-form-label font-weight-bold">Turn-In: <span class="font-weight-normal">' . (($homework_result->turnedin==1)?'Yes':'No') . '</span></label>
            </div>
            </div>
            <div class="row">
            <div class="col-6 align-items-right">
                <label class="align-middle col-form-label font-weight-bold">Overdue: <span class="font-weight-normal">' . $homework_result->updated_at->format('d-m-Y') . '</span></label>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label class="align-middle col-form-label font-weight-bold">Remark: </label>
                    <p>
                     ' . 
                     nl2br($homework_result->remark)
                     . '    
                    </p>
             
            </div>

          
        </div>

        <div class="row">
            <div class="col-12">
                <label class="align-middle col-form-label font-weight-bold">Attachments: </label>
                    <p>
                        <ul class="list-group list-group-numbered">
                           '.  $attachments . '
                
                        </ul>
                    </p>
                    
            </div>

          
        </div>
        <div class="row">
        <div class="col">
            <label class="align-middle col-form-label font-weight-bold">Score:</label> <br/>
             <input type="number" name="score" value="' . old("score",$homework_result->score) . '" max="'. $homework_result->homework->marks  .'">
          </div></div>
          <div class="row">
        <div class="col">
        <label class="align-middle col-form-label font-weight-bold">Teacher\'s Comment:</label> <br/>
        <textarea class="form-control" rows="5" name="teacher_comment">' . $homework_result->teacher_comment . '</textarea>
        </div>
        </div>
          
          ';

            return response()->json(['status'=>'success','html'=>$html,'attachment'=>(($attachments=='')?false:true)]);
        }
        
    }

    public function done(Homework $homework,Request $request){
        
        if($request->has('done')){

            $homework->completed=$request->done;
            $homework->save();
            
            if($request->done==1)
                $message = "The Homework move to completed list.";
            else
                $message = "The Homework move back to assignment list.";

            return redirect()->route('admin.homework.index')->with('message',$message);
        }

    }

    public function ajaxhomework(Request $request){
        if($request->ajax()){
            $class = $request->input('class');
            $language = $request->input('language');
            $course = $request->input('course');
            
            $filter = $request->input('filter');

            $data = Homework::where('user_id',auth()->user()->id)->when($filter, function($q) use($filter) {
                $q->where('term',$filter['term']);
                if($filter['class']>0)
                    $q->where('class_id',$filter['class']);
                
                if($filter['status']!=-1)
                    $q->where('submitted', ($filter['status']=="Published")?1:0);

                if(($filter['language'] != trans('global.pleaseSelect')) && (!empty($filter['language'])))
                    $q->whereHas('course',function($q) use($filter){
                        $q->where('language',$filter['language']);
                    });       
                if($filter['course']>0)
                    $q->where('course_id',$filter['course']);    
            })->where('completed',$request->completed)->orderBy('created_at','desc');
       
        return Datatables::of($data->get())
        ->addIndexColumn()

        ->addColumn('course_name',  function(Homework $homework){
            return $homework->course->name;
        })
        ->addColumn('class_name',  function(Homework $homework){
            return $homework->class->name;
        })
        ->editColumn('added_on_date',  function(Homework $homework){
            return $homework->added_on_date->format('d-m-Y H:i');
        })
        ->editColumn('due_date',  function(Homework $homework){
            return $homework->due_date->format('d-m-Y H:i');
        })
        ->addColumn('student_submit', function(Homework $homework){
            $stdent_submit = $homework->homeworkresult->where('turnedin',1)->count();
            $stdent_perclass = User::whereHas('class', function($q) use($homework){
                $q->where('class_id', $homework->class_id);
            })->count();
            return "<span class='badge " . (($stdent_submit==$stdent_perclass)?'bg-success':'bg-primary') . " p-2'>{$stdent_submit}/{$stdent_perclass}</span>";
        })
        ->editColumn('submitted',  function(Homework $homework){
            return ($homework->submitted==0)?'No':'Yes';
        })
        ->editColumn('description',  function(Homework $homework){
            return preg_replace('/<\/?[^>]+(>|$)/', "",$homework->description);
        })
        ->addColumn('remark', function(Homework $homework){
            return '';
        })
        ->addColumn('group_col', function(Homework $homework){
            return (($homework->submitted==1)?'Publish Assigment':'Unpublish Assignment');
        })
        ->addColumn('action', function(Homework $homework) use($request){

            if($request->completed==0){
                $action ='<a href="' .  route('admin.homework.edit',[$homework]) . '" class="btn btn-xs  btn-primary">Edit</a> ';
                if($homework->submitted===0){
                    $action = $action . "<span class='text-success'>|</span> <form action='" . route('admin.homework.destroy',$homework->id) . "' method='POST' onsubmit='return confirm(\"" . trans('global.areYouSure') . "\");' style='display: inline-block;'>";
                    $action = $action . '<input type="hidden" name="_method" value="DELETE">';
                    $action = $action . '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    $action = $action . '<input type="submit" class="btn btn-xs btn-danger" value="' . trans('global.delete') . '">';
                    $action = $action . '</form>';
                }
            
                if($homework->submitted==1){
                    $action = $action . ' <span class="text-success">|</span> ';    
                    $action = $action . '<a href="' .  route('admin.homework.show',[$homework]) . '" class="btn btn-xs btn-primary">Input Score</a> ';
                   // $action .='<a href="' .  route('admin.homework.view', [$homework]) . '" class="btn btn-xs btn-success"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Done</a>';

                    $action = $action . "<span class='text-success'>|</span> <form action='" . route('admin.homework.done',$homework->id). "' method='POST' onsubmit='return confirm(\"" . trans('global.areYouSure') . "\");' style='display: inline-block;'>";
                    $action = $action . '<input type="hidden" name="done" value="1">';
                    $action = $action . '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    $action = $action . '<input type="submit" class="btn btn-xs btn-danger" value="Done">';
                }
            }else{
               // $action ='<a href="' .  route('admin.homework.edit',[$homework]) . '" class="btn btn-xs  btn-primary">Move Back</a> ';
                    $action = "<form action='" . route('admin.homework.done',$homework->id). "' method='POST' onsubmit='return confirm(\"" . trans('global.areYouSure') . "\");' style='display: inline-block;'>";
                    $action = $action . '<input type="hidden" name="done" value="0">';
                    $action = $action . '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    $action = $action . '<input type="submit" class="btn btn-xs btn-danger" value="Move Back"> <span class="text-success">|</span>';
                    $action .='<a href="' .  route('admin.homework.view', [$homework]) . '" class="btn btn-xs btn-primary">View Score</a> ';
              
            }
            
            return $action;
        })
        ->rawColumns(['description','action','student_submit'])
        ->make(true); //// ->setTotalRecords(5)
        }

    }

    public function ajaxUpload(Request $request){

        if($request->hasFile('file'))
        {

            $homework = Homework::find($request->trid);
            
            $allowedfileExtension=['pdf','jpg','png','gif','docx','doc','xls','xlsx','pptx','ppt'];
            $files = $request->file('file');
            
            $attach_files = $homework->attachments->pluck('id','filename')->toArray();


            
            foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            


           if(in_array(pathinfo($filename)['filename'],$attach_files)) continue;

            //$check=in_array($extension,$allowedfileExtension);
           
            $newfilename = date('Ymd-H-i-s') . '-' . $filename;
            
            //if($check)
                //{
               // $items= Item::create($request->all());
              
                    // foreach ($request->docs as $doc) {
                        $path=$file->storeAs('docs',$newfilename);
                        $arr_data=new HomeworkAttachment([
                            'filename' => pathinfo($filename)['filename'],
                            'path' =>  $path
                        ]);
                        // 
                        $homework->attachments()->save($arr_data);
                        
                   // }

                   
                // }else {
                //     return response()->json(['status'=>'deny']);
                // }

           }

            Session::flash('message', 'Assignment has been updated successfully!');
            return response()->json(['status'=>'success']);


        }

    }


    public function store(Request $request){

        if($request->ajax()){
        $data = [
            'user_id' => auth()->user()->id,
            'name' =>  $request->name,  //. '-' . $request->course,
            'term' => $request->term,
            'description' => $request->homework,
            'course_id' => $request->course,
            'class_id' => $request->classes,
            'added_on_date' => date('Y-m-d H:i:s'),
            'due_date' => Carbon::createFromFormat('d/m/Y H:i:s', $request->due_date)->format("Y-m-d H:i:s"),
            'submitted' => ($request->save_send == 'save')?0:1,
            'marks' => $request->marks, 
            // 'status' => 0,
        ];

        
        $homework=Homework::create($data);
      
        $student_ids = $homework->class->classUsers->pluck('id');
        //return response()->json($student_ids);
        foreach($student_ids as $student_id){
            $data = new HomeworkResult(['user_id'=>auth()->user()->id,'homework_id'=>$homework->id,'student_id'=> $student_id,'turnedin'=>0]);
            $homework->homeworkresult()->save($data);
        }

                if($request->save_send != 'save'){

                $students = User::whereHas('roles', function($q){
                    $q->whereId(4);
                })->whereHas('class', function($q) use($homework) {
                    $q->where('class_id',$homework->class_id);
                })
                ->has('firebasetokens')
                ->get();
                
                // return response()->json($students->firebasetokens->get());

                $title ="Assignments";
                $body = "You have assignment " . $homework->course->name . " with due date " . $homework->due_date->format('d-m-Y H:i');
                $fcmTokens=[];
                foreach($students as $student){
                    $fcmTokens_temp=$student->firebasetokens()->pluck('firebasekey')->toArray();
                   // $fcmTokens=array_merge($fcmTokens,$fcmTokens_temp);
                    $student->notify(new FirebaseNotification($title,$body,$fcmTokens_temp,$title,$homework->id,'','assignment'));   
                }
               // return response()->json($fcmTokens);
                //$fcmTokens = $students->firebasetokens()->pluck('firebasekey')->toArray();
                // Notification::send(auth()->user(),new FirebaseNotification($title,$body,$fcmTokens,$title,$homework->id,'','assignment')); 
            
            }
            return response()->json(['status'=>'success','trid' =>$homework->id]);
        }

        return redirect()->route('admin.homework.create')->with('message','The Homework has been created.');
    }

    public function savescore(Homework $homework, Request $request){

        // if(!is_array($request->trids))
        if($request->trid<=0)
            return redirect()->route('admin.homework.show',[$homework->id])->with('message','No student score to save.');

            $result=$homework->homeworkresult->find($request->trid);
            $result->score = $request->score;
            $result->teacher_comment = $request->teacher_comment; 
            $result->save();
        // foreach($request->trids as $k=>$trid){
        //     $result=$homework->homeworkresult->find($trid);
        //     // dd($result);
        //     $result->score = $request->scores[$k];
        //     $result->save();
        // }
        
        return redirect()->route('admin.homework.show',[$homework->id])->with('message','The Student Score has been saved.');
    }

    public function update(Homework $homework, Request $request){

        if($request->ajax()){
        $data = [
            'user_id' => auth()->user()->id,
            'name' =>  $request->name,
            'description' => $request->homework,
            'course_id' => $request->course,
            'class_id' => $request->classes,
            'term' => $request->term,
            'added_on_date' => date('Y-m-d H:i:s'),
            'due_date' => Carbon::createFromFormat('d/m/Y H:i:s', $request->due_date)->format("Y-m-d H:i:s"),
            'submitted' => ($request->save_send == 'save')? (($homework->submitted==1)?1:0) :1,
            'marks' => $request->marks, 
            // 'status' => 0,
        ];

        // dd($data);
          // $homework=Homework::find($);
            $homework->update($data);
            // Delete file from datbase and storage
            if($request->has('deleted_files')){
                $file_deleteds=HomeworkAttachment::whereIn('id',explode(",",$request->deleted_files))->get();
                
                // return response()->json($file_deleteds);

                foreach($file_deleteds as $f){
                        $path = $f->path;
                        if(Storage::exists($path))
                            Storage::delete($path);
                            $f->delete();
                    
    
                }
            }
            
            if($request->save_send != 'save'){
            
                
                $students = User::whereHas('roles', function($q){
                    $q->whereId(4);
                })->whereHas('class', function($q) use($homework) {
                    $q->where('class_id',$homework->class_id);
                })
                ->has('firebasetokens')
                ->get();

                if($homework->save_send=='send'){

                    $student_ids = $homework->class->classUsers->pluck('id');
                    foreach($student_ids as $student_id){
                        $data = new HomeworkResult(['user_id'=>auth()->user()->id,'homework_id'=>$homework->id,'student_id'=> $student_id,'turnedin'=>0]);
                        $homework->homeworkresult()->save($data);
                    }
                    
                    $title ="Assignments";
                    $body = "You have assignment course " . $homework->course->name . " with due date " . $homework->added_on_date->format('d-m-Y H:i');
                }else{ //resend
                    $title ="Assignment";
                    $body = "Assigned Course " . $homework->course->name . ' has been modified. Please review content.' ;
                }
               
                $fcmTokens=[];
                foreach($students as $student){
                    $fcmTokens_temp=$student->firebasetokens()->pluck('firebasekey')->toArray();
                   // $fcmTokens=array_merge($fcmTokens,$fcmTokens_temp);
                    $student->notify(new FirebaseNotification($title,$body,$fcmTokens_temp,$title,$homework->id,'','assignment'));   
                }
               // return response()->json($fcmTokens);
                //$fcmTokens = $students->firebasetokens()->pluck('firebasekey')->toArray();
                //Notification::send(auth()->user(),new FirebaseNotification($title,$body,$fcmTokens,$title,$homework->id,'','assignment')); 
            
            
            }
            Session::flash('message', 'Assignment has been updated successfully!');
            return response()->json(['status'=>'success','trid' =>$homework->id]);
        }

        return redirect()->route('admin.homework.create')->with('message','The Homework has been created.');
    }

    
    public function destroy(Homework $homework)
    {
      //  abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
   
        foreach($homework->attachments as $attch){
            if(Storage::exists($attch->path))
                Storage::delete([$attch->path]);
            $attch->delete();
        }
        
        $homework->delete();

        return back();
    }

}
