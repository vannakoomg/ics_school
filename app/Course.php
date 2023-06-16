<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $appends =['fullimage','firstvideo']; 

    public $table = 'course';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'language',
        'description',
        'image',
        'color',
    ];

    public function getFirstVideoAttribute(){
        $rec = Elearning::where('course_id',$this->id)->first();

        return $rec ? $rec->url : '';
    }

    public function getFullImageAttribute(){
        if(empty($this->image))
            return '';

        return asset('storage/image/' . $this->image);
    }

    public function elearnings(){
        return $this->hasMany(Elearning::class,'course_id');
    }

    public function examschedules(){
        return $this->hasMany(Examschedule::class,'course_id');
    }

    public function has_timetables(){

        return Timetable::where('monday','LIKE','%"course":"' . $this->id . '"%')
        ->orWhere('tuesday','LIKE','%"course":"' . $this->id . '"%')
        ->orWhere('wednesday','LIKE','%"course":"' . $this->id . '"%')
        ->orWhere('thursday','LIKE','%"course":"' . $this->id . '"%')
        ->orWhere('friday','LIKE','%"course":"' . $this->id . '"%')
        ->orWhere('saturday','LIKE','%"course":"' . $this->id . '"%')
        ->exists();
        
    }

    function class(){
        return $this->belongsToMany(SchoolClass::class, 'course_class', 'course_id','class_id');
    }
}
