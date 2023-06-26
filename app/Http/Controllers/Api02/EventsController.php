<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\EventsType;

use App\Event;
class EventsController extends Controller
{
    public function getEvent(Request $request){
    $stop = new DateTime($request->start);
    $stop = $stop->modify('+ 30day' )->format('Y-m-d');
    $event =  Event::orderBy('start', 'ASC')->get();
    $event= $event->where('start','>=',$request->start)->where('end','<=',$stop);
    $allEvent =collect([]); 
        foreach ($event as $key => $e){
            $begin = new DateTime($e->start);
            $end   = new DateTime($e->end );
            // check event that have more than 1 day 
            for($i = $begin; $i < $end; $i->modify('+1 day' )){
            $time= $i->format('Y-m-d');
            $title =collect([]);
            $color_code = EventsType::find($e->action);
            $title->push([
                    "title"=>$e->title,
                    "action_color"=>"0XFF$color_code->color",
                    "time"=>$e->time
                ],);
            $isdulicat=0;
            // check  anther event have the same date
            foreach ($allEvent as $key => $all){
            if( $allEvent[$key]["date"]==$time){
                $color_code = EventsType::find($e->action);
                $allEvent[$key]['event']->push([
                "title"=>$e->title,
                "action_color"=>"0XFF$color_code->color",
                "time"=>$e->time
                ]);
                $isdulicat=1;
                break 1;
            }
            } 
            if( $isdulicat==0){
                $allEvent ->push([
            "date"=> $time,
            "event"=>$title
        ]);}}
        }
    return response()->json([
                "data"=>$allEvent
            ],);
    }   
}