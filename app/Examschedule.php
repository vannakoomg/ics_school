<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Examschedule extends Model
{
    use HasFactory;

    public $table = 'exam_schedules';

    protected $dates = [
        'created_at',
        'updated_at',
        
  
    ];

    protected $appends = ['date_format'];

    protected $fillable = [
        'user_id',
        'date',
        'end_time',
        'start_time',
        'course_id',
        'title',
        'room'
   
    ];

    const WEEK_DAYS = [
        '2' => 'Monday',
        '3' => 'Tuesday',
        '4' => 'Wednesday',
        '5' => 'Thursday',
        '6' => 'Friday',
        '7' => 'Saturday',
        '1' => 'Sunday',
    ];

    function class()
    {
        return $this->belongsToMany(SchoolClass::class, 'examschedules_class', 'examschedules_id','class_id');   
    }

    function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getDateFormatAttribute(){
        return $this->date ? Carbon::parse($this->date)->format('d/m/Y') : null;
    }   
    
    public function getStartTimeAttribute($value){
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }   

    public function getEndTimeAttribute($value){
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }   

    // public function getDateAttribute($value){
    //     return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    // }


	protected function isDuplicateEntryException(Illuminate\Database\QueryException $e){
		$errorCode  = $e->errorInfo[1];
		if ($errorCode === 1062) { // Duplicate Entry error code
			return true;
		}
		return false;
	}


}
