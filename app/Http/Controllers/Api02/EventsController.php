<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

use App\Event;
class EventsController extends Controller
{
    public function getEvent(){
    $event= Event::all();
    $allEvent =collect([]); 
        foreach ($event as $key => $e){
            $begin = new DateTime($e->start);
            $end   = new DateTime($e->end );
            // check event that have more than 1 day 
            for($i = $begin; $i < $end; $i->modify('+1 day' )){
            $time= $i->format('Y-m-d');
            $title =collect([]);
            $title->push([
                    "title"=>$e->title,
                    "action_color"=>$e->action_color
                ],);
            $isdulicat=0;
            // check  anther event have the same date
            foreach ($allEvent as $key => $all){
            if( $allEvent[$key]["date"]==$time){
                $allEvent[$key]['event']->push([
                "title"=>$e->title,
                "action_color"=>$e->action_color
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