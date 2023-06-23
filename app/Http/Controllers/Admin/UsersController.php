<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\SchoolClass;
use App\User;
use App\Course;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use DataTables;

// use PDF;
// use Mpdf\Mpdf;
// use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersController extends Controller
{

    private $collection_guardian =['Father','Mother','Relative'];


    public function student_promote(Request $request){
        abort_if(Gate::denies('school-setup') && Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $campus = SchoolClass::groupBy('campus')->pluck('campus','campus'); //->prepend(trans('global.pleaseSelect'), '');

        $campus_selected = request()->has('campus')?request()->campus:$campus['MC'];

        $current_filter = [
            'campus' => $campus_selected
        ];

        
        //--------- Prrocess update ----------------
        if(!empty($request->btn_promote)){
           
            $ids = $request->input('chk', []);

            User::whereIn('id',$ids)->update(['class_id'=>$request->new_class]);

        }

        //--------- End of Process update ----------

        $users = User::with(['class' =>function($q){
            $q->orderBy('campus','desc')->orderByRaw("FIELD(level_type,'Kindergarten','Kindergarten','Secondary')");
        }])->whereHas('class', function($q) use ($campus_selected, $request){
                        
                            if($request->has("itclass"))
                                $q->where('campus',$campus_selected);
                            else
                                $q->whereNotIn('class_id',[68])->where('campus',$campus_selected);
                    
            })->get()->sortBy('sorts')->sortBy('sorts1');
            
            $cur_user = $users->where('class_id', $request->cur_class ?? 0);
            $new_user = $users->where('class_id', $request->new_class ?? 0); 
            
            $classes = SchoolClass::where('campus',$campus_selected)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

          
       
        return view('admin.users.promote', compact('users', 'campus','cur_user','new_user','classes','current_filter'));
    }

    public function index(Request $request)
    {

//	dd('ddd');      
        abort_if(Gate::denies('school-setup') && Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->role );
        $campus = SchoolClass::groupBy('campus')->pluck('campus','campus'); //->prepend(trans('global.pleaseSelect'), '');
       // $campus = ['MC'=>'MC','CC'=>'CC'];
        $campus_selected = request()->has('campus')?request()->campus:$campus['MC'];

        $current_filter = [
            'campus' => $campus_selected
	];

//	dd($campus);
       
        return view('admin.users.index', compact('campus','current_filter'));
    }

    public function create()
    {
        abort_if(Gate::denies('school-setup') && Gate::denies('user_create') , Response::HTTP_FORBIDDEN, '403 Forbidden');

        request()->session()->put('email', '');
        request()->session()->put('password', '');

        $roles = Role::whereNotIn('id',[3,4])->get()->pluck('title', 'id');

        $courses = Course::select(DB::raw("CONCAT(language,'-',name) as newname"),'id')->orderBy('language','asc')->orderBy('name','asc')->get()->pluck('newname', 'id'); //prepend(trans('global.pleaseSelect'), '');
        $classes = SchoolClass::select(DB::raw("CONCAT(name,'-', campus) as newname"),'id')->get()->pluck('newname', 'id');
        $collection_guardian = Arr::prepend($this->collection_guardian, 'Select One Item');
        
        return view('admin.users.create', compact('roles', 'classes','courses','collection_guardian'));
    }


    public function pickup_report(Request $request){
       
        if($request->has('campus'))
            $selected_campus=SchoolClass::where('campus',$request->input('campus'))->first();
        else
            $selected_campus=SchoolClass::groupBy('campus')->first();
           
        if($request->has('class'))
            $selected_class = SchoolClass::find($request->input('class'));
        else
            $selected_class = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->first();
    
        $schoolClasses = SchoolClass::where('campus',$selected_campus->campus)->orderBy('name','asc')->get();
    
       
        $users = User::whereHas('roles', function ($query){
                $query->whereId(4);
            })->whereHas('class', function($query) use ($selected_class){
                $query->where('id',$selected_class->id);
            })
        ->get();
        

        $user=null;

        if($request->has('btn_preview'))
            return view('admin.users.show', compact('user','users'));
        elseif($request->has('btn_pdf_back')){

           // return view('admin.users.pdf-back', compact('selected_campus','user','users','schoolClasses','selected_class'));

            view()->share('user',null);
            view()->share('users',$users);

           // PDF::setOptions(['dpi'=>150]);
            $pdf = PDF::loadView('admin.users.pdf-back',compact($user, $users))->setPaper('a4','landscape');
            // $pdf->setOptions(['dpi'=>120]);
            return $pdf->download('pickupcard-back-' . $selected_class->name .'.pdf');
            //return view('admin.users.pdf', compact('user','users'));

        }elseif($request->has('btn_pdf_front')){

            // return view('admin.users.pdf-back', compact('selected_campus','user','users','schoolClasses','selected_class'));
 
             view()->share('user',null);
             view()->share('users',$users);
 
            // PDF::setOptions(['dpi'=>150]);
             $pdf = PDF::loadView('admin.users.pdf-front',compact($user, $users))->setPaper('a4','landscape');
             // $pdf->setOptions(['dpi'=>120]);
             return $pdf->download('pickupcard-front-' . $selected_class->name .'.pdf');
             //return view('admin.users.pdf', compact('user','users'));
 
         }
            

        return view('admin.users.pickup-card', compact('selected_campus','users','schoolClasses','selected_class'));
    }

    public function store(StoreUserRequest $request)
    {
        $data=(array) $request->all();

        if(in_array(3,$request->input('roles', [])))
            unset($data['class_id']);
      
        if(in_array(3,$request->input('roles', [])))
            unset($data['course_id']);
        
        $user = User::create($data);

        if ( $request->hasFile('audio_voice') ) {
            // The file
            $music_file = $request->file('audio_voice');
        
            // This will return "mp3" not the file name
            $extension = $music_file->getClientOriginalExtension();
        
            // This will return /audio/mp3
            // $location = public_path('audio/' . $filename);
        
            // This will move the file to /public/audio/mp3/
            // and save it as "mp3" (not what you want)
            // example: /public/audio/mp3/mp3 (without extension)
            // $music_file->move($location,$filename);
        
            // mp3 row in your column will just say "mp3"
            // since the $filename above is just an extension of the file
            $fileName =  "{$user->email}.{$extension}";
            $request->audio_voice->storeAs('audio', $fileName);

            $user->update(['voice' => $fileName]);
        }

        if ($files = $request->file('imgupload')) {
                // Storage::delete(['photo/' . $user->photo]);
                $fileName =  "{$user->email}.png";
                $request->imgupload->storeAs('photo', $fileName);

                $user->update(['photo' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload1')) {
               
                $fileName =  "{$user->id}_guardian1.png";
                $request->collect_imgupload1->storeAs('photo', $fileName);

               // $request->request->add(['guardian1' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload2')) {

            if(strtolower($user->guardian2)!='guardian-avatar.png')
                Storage::delete(['photo/' . "{$user->id}_guardian2.png"]);
               
                $fileName =  "{$user->id}_guardian2.png";
                $request->collect_imgupload2->storeAs('photo', $fileName);

               // $request->request->add(['guardian2' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload3')) {

            if(strtolower($user->guardian3)!='guardian-avatar.png')
                Storage::delete(['photo/' . "{$user->id}_guardian3.png"]);
        
                $fileName =  "{$user->id}_guardian3.png";
                $request->collect_imgupload3->storeAs('photo', $fileName);

               // $request->request->add(['guardian3' => $fileName]);
        }

        $user->roles()->sync($request->input('roles', []));
        $user->classteacher()->sync($request->input('class_id', []));
        $user->courseteacher()->sync($request->input('course_id', []));
        

        return redirect()->route('admin.users.index',['role' => $user->roles->contains(3)?3:($user->roles->contains(4)?4:0)]);
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('school-setup') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::select(DB::raw("CONCAT(language,'-',name) as newname"),'id')->orderBy('language','asc')->orderBy('name','asc')->get()->pluck('newname', 'id'); //prepend(trans('global.pleaseSelect'), '');
        $roles = Role::whereNotIn('id',[3,4])->get()->pluck('title', 'id');

        $classes = SchoolClass::select(DB::raw("CONCAT(name,'-', campus) as newname"),'id')->get()->pluck('newname', 'id'); //prepend(trans('global.pleaseSelect'), '');

        $user->load('roles', 'class');

        $collection_guardian = Arr::prepend($this->collection_guardian, 'Select One Item');
        
        return view('admin.users.edit', compact('roles', 'classes','courses', 'user','collection_guardian'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {    

        if ($files = $request->file('imgupload')) {
           // dd($user->photo);
            if(strtolower($user->photo)!='student-avatar.png')
                    Storage::delete(['photo/' . $user->photo]);
                // Storage::delete(['photo/' . $user->photo]);
                $fileName =  "{$user->email}.png";
                $request->imgupload->storeAs('photo', $fileName);

                $request->request->add(['photo' => $fileName]);
        }


        if ( $request->hasFile('audio_voice') ) {
            // The file
            $music_file = $request->file('audio_voice');
            Storage::delete(['audio/' . $user->voice]);
            // This will return "mp3" not the file name
            $extension = $music_file->getClientOriginalExtension();

            // since the $filename above is just an extension of the file
            $fileName =  "{$user->email}.{$extension}";
            $request->audio_voice->storeAs('audio', $fileName);

            $user->update(['voice' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload1') && $request->guardian1) {
           
            if(strtolower($user->guardian1)!='guardian-avatar.png')
                    Storage::delete(['photo/' . "{$user->id}_guardian1.png"]);
               
                $fileName =  "{$user->id}_guardian1.png";
                $request->collect_imgupload1->storeAs('photo', $fileName);
                // $user->update(['guardian1' => $fileName]);
               // $request->request->add(['guardian1' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload2') && $request->guardian2) {
            
            if(strtolower($user->guardian2)!='guardian-avatar.png')
                Storage::delete(['photo/' . "{$user->id}_guardian2.png"]);
               
                $fileName =  "{$user->id}_guardian2.png";
                $request->collect_imgupload2->storeAs('photo', $fileName);
               // $user->update(['guardian2' => $fileName]);
               // $request->request->add(['guardian2' => $fileName]);
        }

        if ($files = $request->file('collect_imgupload3') && $request->guardian3) {

            if(strtolower($user->guardian3)!='guardian-avatar.png')
                Storage::delete(['photo/' . "{$user->id}_guardian3.png"]);
        
                $fileName =  "{$user->id}_guardian3.png";
                $request->collect_imgupload3->storeAs('photo', $fileName);
                //$user->update(['guardian3' => $fileName]);
               // $request->request->add(['guardian3' => $fileName]);
        }

        $data=(array) $request->all();

        if(in_array(3,$request->input('roles', []))){
            unset($data['class_id']);
            unset($data['course_id']);
           
        }

        $user->update($data);
        //  dd($request->input('class_id', []));
        $user->roles()->sync($request->input('roles', []));
    
        if(in_array(3,$request->input('roles', []))){
            $user->classteacher()->sync($request->input('class_id', []));
            $user->courseteacher()->sync($request->input('course_id', []));

        }

        //return redirect()->route('admin.users.index');
        if(in_array(4,$request->roles))
            return redirect()->route('admin.users.index',['role'=>4,'campus'=>$user->class->campus]);
        elseif(in_array(3,$request->roles))
            return redirect()->route('admin.users.index',['role'=>3]);    
        else
            return redirect()->route('admin.users.index');
            
    }

    public function ajax_userlist(Request $request){
        if($request->ajax()){
            $campus = SchoolClass::groupBy('campus')->pluck('campus','campus'); 
            $campus_selected = !empty($request->campus)?$request->campus:$campus['MC'];
          
            // $data = User::with(['class' =>function($q){
            //     $q->orderBy('campus','desc')->orderByRaw("FIELD(level_type,'Kindergarten','Kindergarten','Secondary')");
            $user_show = false;
            $user_edit = false;
            $user_delete = false;

            if(Gate::allows('user_show'))
                $user_show = true;
            if(Gate::allows('user_edit'))
                $user_edit = true;
            if(Gate::allows('user_delete'))
                $user_delete = true;
                    
            $data = User::with(['class' =>function($q){
               //$q->orderBy('campus','desc')->orderByRaw("FIELD(level_type,'Kindergarten','Kindergarten','Secondary')");
               //$q->orderByRaw("FIELD(level_type,'Kindergarten','Kindergarten','Secondary')")->orderBy('orders');
            }])->when($request->role == 0, function ($query) use ($request) {
                    $query->whereHas('roles', function ($query) use ($request) {
                        $query->whereNotIn('id',[3,4]);
                    }); 
                })->when($request->role > 0, function ($query) use ($request) {
                    $query->whereHas('roles', function ($query) use ($request) {
                        $query->whereId($request->role);
                    }); 
                })->when($request->role, function($q) use($request, $campus_selected){
                    if($request->role==4)
                        $q->whereHas('class', function($q) use ($campus_selected, $request){
                            if($request->has("itclass"))
                                $q->where('campus',$campus_selected);
                            else
                                $q->whereNotIn('class_id',[68])->where('campus',$campus_selected);
                        });
                    
                    elseif($request->role==3)
                        $q->whereHas('classteacher', function($q) use ($campus_selected){
                            $q->where('campus',$campus_selected);
                        });    
                });//>get()->sortBy('sorts')->sortBy('sorts1')
                //$sql = $data->toSql();
                return Datatables::of($data->get()->sortBy('class.orders'))
                ->addColumn('DT_RowId', function(User $user){

                    return $user->id;
                })
                ->editColumn('photo', function(User $user){
                    return '
                       <div style="padding:0;margin:0;width: 100px;max-height:110px;height:100px;overflow:hidden;border:1px solid #d1d1d1" >
                           <img clas="img-fluid img-thmbnail" src="' .  $user->full_image . '" style="width:100%;height:auto">
                       </div>';
                        //(!empty($user->photo) ? asset('storage/photo/' . $user->photo) : ($user->roles->contains(3) ? asset('storage/image/teacher-avatar.png'):asset('storage/image/student-avatar.png')))
                })
                ->editColumn('rfid', function(User $user){
                    return ($user->rfidcard ? '<i class="fa fa-check" aria-hidden="true"></i>':'');
                })
                ->addColumn('roles' , function(User $user){
                    $arr='';
                    foreach($user->roles as $key => $item){
                           $arr .='<span class="badge badge-info">' . $item->title .'</span>';
                    }
                     return $arr;
                })
                ->addColumn('DT_RowIndex' , function(User $user){

                    return 'row_' . $user->email;
                })
                ->addColumn('fullname' , function(User $user){
                    // return $sql;
                    return (empty($user->namekh) ? '':$user->namekh . '<br/>')  . ($user->name);
                })
                ->addColumn('checkbox' , function(User $user){
                    return '';
                })
                ->addColumn('course_name' , function(User $user){
                    $htnl='';
                    if($user->roles->contains(3)){
                        foreach($user->courseteacher as $course)
                            $htnl .='<span class="badge badge-success">' . $course->language . '-' .  $course->name . '</span>';
                    }
                    return $htnl;
                })
                ->addColumn('classes' , function(User $user){
                    $str='';
                    if($user->roles->contains(3)){
                            foreach($user->classteacher as $class){
                                $str .='<span class="badge badge-success">' . $class->name . '</span>';
                            }
                    }else{
                                $str .=($user->class->name ?? '');
                    }
                    return $str;
                })     
                ->addColumn('voice' , function(User $user){    
                        $str='';   
                       
                        if($user->voice){
                                $str .='<input type="button" class="btn btn-sm btn-primary btn_play" value="Play">';
                                $str .='<audio controls class="btn btn-sm" style="padding:0px;margin:0;display:none";>';
                                $str .='<source src="' .  (Storage::exists('/audio/' . $user->voice)?asset('storage/audio/' . $user->voice):'') . '" type="audio/mp3">';
                                $str .='</audio>';
                        }
                        return $str;
                })
                ->addColumn('action' , function(User $user, Request $request) use ($user_show, $user_edit, $user_delete){    
                    $str='';  

                    if($user_show){
                        $str='<a class="btn btn-xs btn-primary text-nowrap" href="' . route('admin.users.show', ['user'=>$user->id,'role'=> $request->role]). '">' . 
                            trans('Collection Card') . '</a> <br/>';
                    }

                    if($user_edit){
                    $str= $str . ' <a class="btn btn-xs btn-info" href="' . route('admin.users.edit', $user->id) . '">' 
                            . trans('global.edit') 
                            . '</a>';
                     }

                    if($user_delete){
                    $str= $str .  ' <form action="' . route('admin.users.destroy', $user->id) . '" method="POST" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <input type="submit" class="btn btn-xs btn-danger" value="' . trans('global.delete') . '">
                                    </form>';
                         }
                    return $str;
                })
                ->rawColumns(['photo','fullname','rfid','roles','classes','voice','action','course_name'])
                ->make(true);

        }
        
    }

    public function show(Request $request, User $user)
    {
        abort_if(Gate::denies('school-setup') && Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $user->load('roles', 'class', 'teacherLessons');

        if($request->has('print') && $request->print=='pdf_front'){

        //     // return view('admin.users.pdf', compact('user'));

        //     $dompdf = new Dompdf();
        //     $options = $dompdf->getOptions();
        //     $options->setDefaultFont('Courier');
        //     $dompdf->setOptions($options);

        //     $dompdf->loadHtml();

        //     // (Optional) Setup the paper size and orientation
        //    // $dompdf->setPaper('A4', 'landscape');

        //     // Render the HTML as PDF
        //     $dompdf->render();

        //     // Output the generated PDF to Browser
        //     $dompdf->stream();

        //---------end ----------------
         
       // return view('admin.users.pdf', compact('user'));

        view()->share('user',$user);
        PDF::setOptions(['dpi'=>200]);
        
        $pdf = PDF::loadView('admin.users.pdf-front', $user->toArray())->setPaper('a4','landscape');
        
        return $pdf->download('pickupcard-front-' . $user->name .'.pdf');

            //----------- end -----------------
            // $view = \View::make('admin.users.show', compact('user'));
            // $htm = $view->render();

            // $pdf = PDF::loadHTML($htm);
            
            // return $pdf->download('collectioncard_' . $user->email .'.pdf');
             //---------end ----------------
            // view()->share('user',$user);
            // $pdf = PDF::loadView('admin.users.show', $user);
            // return $pdf->download('pdf_file.pdf');
            

        }
        elseif($request->has('print') && $request->print=='pdf_back'){

            //     // return view('admin.users.pdf', compact('user'));
    
            //     $dompdf = new Dompdf();
            //     $options = $dompdf->getOptions();
            //     $options->setDefaultFont('Courier');
            //     $dompdf->setOptions($options);
    
            //     $dompdf->loadHtml();
    
            //     // (Optional) Setup the paper size and orientation
            //    // $dompdf->setPaper('A4', 'landscape');
    
            //     // Render the HTML as PDF
            //     $dompdf->render();
    
            //     // Output the generated PDF to Browser
            //     $dompdf->stream();
    
            //---------end ----------------
             
           // return view('admin.users.pdf', compact('user'));
    
            view()->share('user',$user);
            PDF::setOptions(['dpi'=>200]);
            
            $pdf = PDF::loadView('admin.users.pdf-back', $user->toArray())->setPaper('a4','landscape');
            
            return $pdf->download('pickupcard-back-' . $user->name .'.pdf');
    
                //----------- end -----------------
                // $view = \View::make('admin.users.show', compact('user'));
                // $htm = $view->render();
    
                // $pdf = PDF::loadHTML($htm);
                
                // return $pdf->download('collectioncard_' . $user->email .'.pdf');
                 //---------end ----------------
                // view()->share('user',$user);
                // $pdf = PDF::loadView('admin.users.show', $user);
                // return $pdf->download('pdf_file.pdf');
                
    
            }else{
            return view('admin.users.show', compact('user'));
        }
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('school-setup') && Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!empty($user->photo) && ($user->photo!='student-avatar.png'))
            Storage::delete(['photo/' . $user->photo]);

        if(!empty($user->guardian1) && ($user->guardian1!='guardian-avatar.png'))
            Storage::delete(["photo/{$user->id}_guardian1.png"]);
        
        if(!empty($user->guardian2) && ($user->guardian2!='guardian-avatar.png'))
            Storage::delete(["photo/{$user->id}_guardian2.png"]);

        if(!empty($user->guardian3) && ($user->guardian3!='guardian-avatar.png'))
            Storage::delete(["photo/{$user->id}_guardian3.png"]);

        if(!empty($user->voice))
            Storage::delete(['audio/' . $user->voice]);
            
        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        foreach(request('ids') as $id){
            $user = User::find($id);
            
            if($user){
                if(!empty($user->photo) && ($user->photo!='student-avatar.png'))
            Storage::delete(['photo/' . $user->photo]);

            if(!empty($user->guardian1) && ($user->guardian1!='guardian-avatar.png'))
                Storage::delete(["photo/{$user->id}_guardian1.png"]);
            
            if(!empty($user->guardian2) && ($user->guardian2!='guardian-avatar.png'))
                Storage::delete(["photo/{$user->id}_guardian2.png"]);

            if(!empty($user->guardian3) && ($user->guardian3!='guardian-avatar.png'))
                Storage::delete(["photo/{$user->id}_guardian3.png"]);

            if(!empty($user->voice))
                Storage::delete(['audio/' . $user->voice]);

            }
        }
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}