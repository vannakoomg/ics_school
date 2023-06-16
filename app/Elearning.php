<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Course;

class Elearning extends Model
{
    use HasFactory;

    public $table = 'elearning';

    protected $appends =['course_name']; 

    protected $dates = [
        'created_at',
        'updated_at',
  
    ];

    protected $fillable = [
        'user_id',
        'course_id',
        'class_id',
        'lesson',
        'description',
        'url',
        'category',
        'active'
   
    ];

    public function getCourseNameAttribute(){

       // $course = Course::find($this->course_id)->first();

        return $this->course->name;
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function class(){
        return $this->belongsToMany(SchoolClass::class, 'elearning_class', 'elearning_id','class_id');
    }

    
}
