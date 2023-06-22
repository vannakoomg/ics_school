<?php

namespace App\Http\Controllers\Api02;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
class EventsController extends Controller
{
    public function getEvent(){
       $event= Event::all();
       $event2=$event;
       $allEvent =collect();
         foreach ($event as $key => $e){
            $title =collect([]);
            $title->push([
                    "title"=>$e->title,
                    "action_color"=>$e->action_color
                ]);
            foreach ($event2 as $key => $ee){
            if($event2[$key]->start == $event2[$key+1]->start ){
                $title->push([
                    "title"=>$event2[$key+1]->title,
                    "action_color"=>$event2[$key+1]->action_color
                ]); 
            }
            if( $event2->last() ==  $event2[$key+1]){
            break 1;
            } 
        }
        $allEvent ->push([
            "date"=> $e->start,
            "event"=>$title
        ]);
        return response()->json([
                "data"=>$allEvent
            ],);
    } 
    }
}