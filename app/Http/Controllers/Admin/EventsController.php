<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use DateTime;
use App\EventsType;


class EventsController extends Controller
{
    public function index(){
      return view('admin.events.index');
    }
    public function show(){
      $eventsType = EventsType::all();
      return view('admin.events.create', compact('eventsType'));
    }
    public function getEvent(){
      $events = Event::all();
      return $events;
    }
    public function store(Request $request){
        $end  = new DateTime($request->end_date);
        $end= $end->modify('+1 day' );
        $endString= $end->format('Y-m-d');
        $data = array(
                'title' => $request->title,
                'start' => $request->startdate,
                'end' => $endString,
                'time' => $request->time,
                'action' => $request->action,
                'create_owner'=>auth()->user()->name
            );
        $value=  Event::create($data);
        return redirect('admin/events');      
    }
    public function destroy(Request $request){
      $result = Event::find($request->id);
      $result->delete();
      return $request->id;
    }
    
}