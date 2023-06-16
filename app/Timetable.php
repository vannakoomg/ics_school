<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timetable extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $appends = ['teacher_name','subject','time']; 
    public $table = 'timetable';

    // protected $cats = ['opti8ons' => 'json'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'class_id',
        'template_id',
        'template_detail_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
    ];

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.timetable_format')) : null;
    }


    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.timetable_format')) : null;
    }


    public function getteacher($column_name){
         $data_temp = $this->{$column_name} ? json_decode( $this->{$column_name},true): [];
         if(array_key_exists('teacher', $data_temp)){
            $data = User::find($data_temp['teacher']);
            $data = $data->name ?? '';
          } else
            $data = '';

        return $data; 
    }

    public function getcourse($column_name){
        $data_temp = $this->{$column_name} ? json_decode( $this->{$column_name},true): [];
        if(array_key_exists('course', $data_temp)){
           $data = Course::find($data_temp['course']);
           $data = $data->name ?? '';
         } else
           $data = '';

       return $data; 
   }

   public function getTimeAttribute(){
     //  return $this->template_detail->start_time . '-' . $this->template_detail->end_time;
    return $this->start_time . ' - ' . $this->end_time;
    }

   public function getTeacherNameAttribute(){
       $arr = json_decode($this->col_val, true);
       $is_teacher = is_array($arr) && array_key_exists('teacher', $arr);
       if($is_teacher)
            $teacher = User::find($arr['teacher'])->name ?? '';
        else
            $teacher = '';
       return $teacher;
   }

   public function getSubjectAttribute(){
    $arr = json_decode($this->col_val, true);
    $is_course = is_array($arr) && array_key_exists('course', $arr);
    if($is_course)
         $course = Course::find($arr['course'])->name ?? '';
     else
         $course = '';
    return $course;
}

   public function class(){

    return $this->belongsTo(SchoolClass::class, 'class_id');
    
   }

   public function breaktime(){
        return 'study time';
   }

   public function template_detail(){
    return  $this->belongsTo(ScheduleTemplateDetail::class, 'template_detail_id');
   } 

}
