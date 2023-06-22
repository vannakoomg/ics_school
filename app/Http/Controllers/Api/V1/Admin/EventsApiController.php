<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsApiController extends Controller
{
      public function getEvents(){
        $result = Event::all();
         
        return ;
    }
}
