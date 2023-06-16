<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    //protected $appends =['fullimage','firstvideo']; 

    public $table = 'class_schedule';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

   

    public function detail(){
        return $this->hasMany(ScheduleTemplateDetail::class, 'school_template_id', 'id'); 
    }

    public function school_class(){
        return $this->belongsToMany(SchoolClass::class, 'class_schedule','schedule_template_id','class_id');
    }
}
