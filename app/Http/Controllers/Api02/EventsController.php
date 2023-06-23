<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
class EventsController extends Controller
{
    public function getEvent(){
    $event= Event::all();
    $allEvent =collect([]);
        foreach ($event as $key => $e){
            // return $e->end.day - $e->start);
            $title =collect([]);
            $title->push([
                    "title"=>$e->title,
                    "action_color"=>$e->action_color
                ]);
            $isdulicat=0;
            foreach ($allEvent as $key => $all){
            if( $allEvent[$key]["date"]==$e->start){
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
            "date"=> $e->start,
            "event"=>$title
        ]);
        }
        }
    return response()->json([
                "data"=>$allEvent
            ],);
    }
}