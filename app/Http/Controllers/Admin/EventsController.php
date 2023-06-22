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
    public function getEvent(){
      $events = Event::all();
      return $events;
    }
    public function store(Request $request){
        $input = $request->all();
        $value=  Event::create($input);
        return  $value;       
    }
    public function deleteEvent(Request $request){
      $result = Event::find($request->id);
      $result->delete();
      return $request->id;
    }
}