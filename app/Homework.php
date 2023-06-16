<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Homework extends Model
{
    // use SoftDeletes;

    public $table = 'homework';

    protected $dates = [
        'added_on_date',
        'due_date',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

 
    protected $appends = ['language','m_teacher','m_duedate','m_createdate','m_classname','m_result']; //'m_assignmentstatus','m_resultstatus'
  
    public function getLanguageAttribute()
    {   
        return $this->course->language;
    }

    protected $fillable = [
        'user_id',
        'term',
        'course_id',
        'class_id',
        'name',
        'description',
        'added_on_date',
        'due_date',
        'submitted',
        'status',
        'marks',
        'completed'
    ];



    function attachments()
    {
        return $this->hasMany(HomeworkAttachment::class);
    }

    public function getMTeacherAttribute(){
        return User::find($this->user_id)->name;
    }

    public function getMDuedateAttribute(){
        return $this->due_date->format('d F Y \\a\\t h:i A');
    }


    public function getMCreatedateAttribute(){
        return $this->created_at->format('d F Y \\a\\t h:i A');
    }

    public function getMClassnameAttribute(){
        return $this->class->name;
    }

    public function getMAssignmentstatusAttribute(){

        return $this->class->name;
    }

    public function getMResultAttribute(){

        return $this->homeworkresult->where('student_id',auth()->user()->id)->first();
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function class(){
        return $this->belongsTo(SchoolClass::class,'class_id');
    }

    public function homeworkresult(){
        return $this->hasMany(HomeworkResult::class,'homework_id');
    }
    
}
