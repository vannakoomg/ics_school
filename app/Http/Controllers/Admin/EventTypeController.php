<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EventsType;

class EventTypeController extends Controller
{
    public function index(){
    $eventsType = EventsType::all();
    return view('admin.eventType.index',compact('eventsType'));
    }
    public function store(Request $request){
        $input = $request->all();
        
        EventsType::create($input);
        return view('admin.eventType.create' );
    }
    public function update(Request $request, $id){
       $eventsType = EventsType::find($id);
       $data = array(
        "name"=>$request->name,
        "color"=>"$request->color"
       );
       $eventsType->update($data);
      return redirect('admin/events/type');   
    }
    public function edit(Request $request){
        $eventsType = EventsType::find($request->id);
        return view('admin.eventType.edit', compact('eventsType'));
    }
    public function destroy (Request $request){
        $eventType = EventsType::find( $request->id);
        $eventType->delete();
         return redirect('admin/events/type');   
    }
     public function show(){
      return view('admin.eventType.create');
    }
}