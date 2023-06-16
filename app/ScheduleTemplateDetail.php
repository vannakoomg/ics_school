<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ScheduleTemplateDetail extends Model
{
    use HasFactory;

    public $table = 'schedule_template_detail';
    protected $appends = ['time']; 

    public $timestamps = false;

    protected $fillable = [
        'start_time',
        'end_time',
        'breaktime',
    ];

    public function getTimeAttribute(){
        $start_time = $this->start_time ? Carbon::createFromFormat('H:i:s', $this->start_time )->format(config('panel.timetable_format')) : null;
        $end_time = $this->end_time ? Carbon::createFromFormat('H:i:s', $this->end_time )->format(config('panel.timetable_format')) : null;
        return $start_time . ' - ' . $end_time;
        }

    // public function getStartTimeAttribute($value)
    // {
    //     return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.timetable_format')) : null;
    // }


    // public function getEndTimeAttribute($value)
    // {
    //     return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.timetable_format')) : null;
    // }

    public function scheduletemplate(){
        return $this->belongsTo(ScheduleTemplate::class, 'school_template_id'); 
    }

    public function timetable(){
        return  $this->hasMany(Timetable::class, 'template_detail_id');
    }

    public function classtimetable(){
        return $this->timetable->where('class_id',auth()->user()->class->id);
    }

    public function getteacher($current_filter,$column_name){
        $timetables = $this->timetable->where('class_id',$current_filter['class_id'])->where('template_id',$current_filter['template_id'])->first();

        $data_temp = $timetables ? ($timetables->{$column_name} ? json_decode( $timetables->{$column_name},true): []):[];
        if(array_key_exists('teacher', $data_temp)){
           $data = User::find($data_temp['teacher']);
           $data = $data->name ?? '';
         } else
           $data = '';

       return $data; 
   }


   public function getcourse($current_filter,$column_name){
    $timetables = $this->timetable->where('class_id',$current_filter['class_id'])->where('template_id',$current_filter['template_id'])->first();

    $data_temp = $timetables ? ($timetables->{$column_name} ? json_decode( $timetables->{$column_name},true): []):[];
       if(array_key_exists('course', $data_temp)){
          $data = Course::find($data_temp['course']);
          $data = $data->name ?? '';
        } else
          $data = '';

      return $data; 
    }

    public function getcoursecolor($current_filter,$column_name){
        $timetables = $this->timetable->where('class_id',$current_filter['class_id'])->where('template_id',$current_filter['template_id'])->first();
    
        $data_temp = $timetables ? ($timetables->{$column_name} ? json_decode( $timetables->{$column_name},true): []):[];
           if(array_key_exists('course', $data_temp)){
              $data = Course::find($data_temp['course']);
              $data = $data->color ?? '';
            } else
              $data = '';
    
          return $data; 
        }


    public function getcurrentid($current_filter){
        $timetables = $this->timetable->where('class_id',$current_filter['class_id'])->where('template_id',$current_filter['template_id'])->first();
        if(! is_array($timetables))
            return 0;
        
        return $timetables->id; 
        }

}
