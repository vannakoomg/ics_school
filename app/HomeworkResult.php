<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeworkResult extends Model
{
    // use SoftDeletes;

    public $table = 'homework_result';

    protected $dates = [
        'created_at',
        'updated_at',
        'turnedindate',
        // 'deleted_at',
    ];

    protected $appends = ['m_status','submit_status'];
  
    public function getLanguageAttribute()
    {   
        return $this->course->language;
    }

    protected $fillable = [
        'user_id',
        'homework_id',
        'student_id',
        'turnedin',
        'remark',
        'score',
        'turnedindate',
        'teacher_comment'
    ];

    public function homework(){
        return $this->belongsTo(Homework::class);
    }

    public function getSubmitStatusAttribute(){

        $homework = Homework::find($this->homework_id);

        $turnin_date = $this->turnedindate?$this->turnedindate->format('d-m-Y'):'';
        $assgined_date = $homework->due_date->format('d-m-Y');

        if(empty($turnin_date))
            $status = 'Not Submit';
        else if($turnin_date <= $assgined_date && $this->turnedin==1)
            $status = 'On-time';
        else if($turnin_date > $assgined_date && $this->turnedin==1)
            $status = 'Late';
        else 
            $status='';

        return $status;
    }

    function getMStatusAttribute(){

       // return  $this->homework();
        $homework = Homework::find($this->homework_id);
        $submitted = $homework->submitted;
        $duedate = $homework->due_date->format('d-m-Y');
        $marks = $homework->marks;
        
        $status='';

        if(($submitted==1) && (date('d-m-Y') <= $duedate) && ($this->turnedin==0))
            $status = 'Assigned';
        else if(($submitted==1) && (date('d-m-Y') > $duedate) && ($this->turnedin==0))
            $status = 'Missing';
        else if(($submitted==1) && ($this->turnedin==1) && ($this->score===0))
            $status = 'Done';
        else if(($submitted==1) && ($this->turnedin==1) && ($this->score>0))
            $status = "{$this->score}/{$marks}";
            
        return $status;
    }

    function attachments()
    {
        return $this->hasMany(HomeworkResultAttachment::class,'homework_result_id');
    }

    function student(){
        return $this->belongsTo(User::class,'student_id');
    }


    // public function class(){
    //     return $this->belongsTo(SchoolClass::class,'class_id');
    // }

  
}
