<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Services\CalendarService;

class CalendarController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $weekDays     = Lesson::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays);
        
        return view('admin.calendar', compact('weekDays', 'calendarData'));
    }
      public function getEvent(){
        if(request()->ajax()){
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $events = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)
                    ->get(['id','title','start', 'end']);
            return response()->json($events);
        }
        return view('fullcalendar');
         
    }
    public function createEvent(Request $request){
        $data = $request->except('_token');
        $events = Event::insert($data);
        return response()->json($events);
    }
    
    public function deleteEvent(Request $request){
        $event = Event::find($request->id);
        return $event->delete();
    }
}