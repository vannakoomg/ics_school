<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
   // use SoftDeletes;

    public $table = 'school_classes';

    protected $appends = ['homeroom','khmer_teacher','teacher_aide','sorts','sorts1'];

    protected $hidden = ['homeroom_id','khteacher_id','teacheraide_id'];

    protected $dates = [
        'created_at',
        'updated_at',
     
    ];

    protected $fillable = [
        'name',
        'campus',
        'roomno',
        'homeroom_id',
        'khteacher_id',
        'teacheraide_id',
        'level_type',
        'created_at',
        'updated_at',
    
    ];

    public function classLessons()
    {
        return $this->hasMany(Lesson::class, 'class_id', 'id');
    }

    public function classUsers()
    {
        return $this->hasMany(User::class, 'class_id', 'id');
    }

    public function elearning()
    {
        return $this->belongsToMany(Elearning::class, 'elearning_class','class_id', 'elearning_id');
    }

    public function examschedule()
    {
        //return $this->hasMany(Examschedule::class, 'class_id', 'id');
        return $this->belongsToMany(Examschedule::class,'examschedules_class','class_id','examschedules_id');
    }

    public function timetable()
    {
        return $this->hasMany(Timetable::class, 'class_id', 'id');
    }

    public function classDlp()
    {
        return $this->hasMany(Dlp::class, 'class_id', 'id');
    }

    public function getHomeroomAttribute(){
        return $this->homeroom_id ? User::find($this->homeroom_id)->name ?? '':'';
    }

    public function getKhmerTeacherAttribute(){
        return $this->khteacher_id ? User::find($this->khteacher_id)->name ?? '':'';
    }

    public function getTeacherAideAttribute(){
        return $this->teacheraide_id ? User::find($this->teacheraide_id)->name ?? '':'';
    }

    public function announcements(){
        return $this->belongsToMany(Announcement::class, 'announcement_class');
    }

    public function getAbsents($status){
          $class_id = $this->id;
          $student_excused = User::whereHas('attendances', function($q) use($status){
                    $q->where('status',$status)->where('date',date('Y-m-d'));
          })->where('class_id',$class_id)->get();

          return $student_excused; 
    }


    public function getStudentAttendances($status,$date){
    $class_id = $this->id;
    if(strtolower($status)=='presentonly')
        $students = User::has('class')->whereNotIn('id', function($query) use($status, $date){
            $query->select('student_id')->from('attendances')->whereIn('status',['Absent & Excused','Absent & Unexcused'])->where('date',$date);
         })->where('class_id',$class_id)->get()->pluck('id')->toArray();
    else
        $students = User::whereHas('attendances', function($q) use($status, $date){
                $q->where('status',$status)->where('date',$date);
        })->where('class_id', $this->id)->get()->pluck('id')->toArray();

    return $students;

    }

    public function teacherclass(){
        return $this->belongsToMany(User::class, 'teacher_class', 'class_id','teacher_id');
    }

    public function course(){
        return $this->belongsToMany(Course::class, 'course_class','class_id','course_id');
    }

    public function schedule_template(){
        return $this->belongsToMany(ScheduleTemplate::class, 'class_schedule','class_id','schedule_template_id');
    }

    public function getSortsAttribute(){
        $str= substr($this->name,0,1);
        
        return $str;
    }

    public function getSorts1Attribute(){
        if(substr($this->name,0,1)=='K') return 0;
        $string= $this->name;
        $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        return $int;
    }

   

}
