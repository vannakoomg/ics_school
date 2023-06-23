<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
class EventsController extends Controller
{
    public function index(){
      return view('admin.events.index');
    }
    public function show(){
      return view('admin.events.create');
    }
    public function getEvent(){
      $events = Event::all();
      return $events;
    }
    public function store(Request $request){
        
        $data = array(
                'title' => $request->title,
                'start' => $request->startdate,
                'end' => $request->end_date,
                'time' => $request->time,
                'action' => $request->action,
                'action_color'=>$request->action=="announcement"?"0XFFFFFF":"0XFF0000",
                'create_owner'=>auth()->user()->name
            );
        $value=  Event::create($data);
        return redirect('admin/events');      
    }
    public function deleteEvent(Request $request){
      $result = Event::find($request->id);
      $result->delete();
      return $request->id;
    }
}