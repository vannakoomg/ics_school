<?php

namespace App\Http\Controllers\Admin;
use App\SchoolClass;
use App\User;
use App\Homework;
use App\HomeworkResult;
use auth;
use App\Userinfo;

class HomeController
{
    public function index()
    {

//	$sqlsvr_userinfo = Userinfo::get()->first();
  //      dd($sqlsvr_userinfo);    
        $classes = User::find(auth()->user()->id)->classteacher()->get();

        // $assign_returns = Homework::has('class')
        //                 // ->where('submitted',1)->whereDate('due_date','<',date('Y-m-d'))
        //                 ->whereHas('homeworkresult', function($q) {
        //                         $q->where('turnedin',1);
        //                 })->where('user_id',auth()->user()->id)->get();
        $assign_returns = Homeworkresult::whereHas('homework', function($q) {
                            $q->where('user_id',auth()->user()->id)->where('completed',0);
                          })->where('turnedin',1)->get();
        
      //  dd($assign_returns[0]->student);

        $data = [
            'unpublish' => Homework::where('user_id',auth()->user()->id)
        ->where('submitted',0)->orderBy('created_at','desc')->get(),
             'publish' => Homework::where('user_id',auth()->user()->id)
        ->where('submitted',1)->where('completed',0)->orderBy('created_at','desc')->get()
        ];
        return view('home',compact('classes','data','assign_returns'));
    }

    

}