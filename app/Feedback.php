<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Feedback extends Model
{
    use HasFactory;

    public $table = 'feedback';

    protected $appends =['date','time','fullimage','replyer']; 

    protected $dates = [
        'created_at',
        'updated_at',
      
    ];

    protected $fillable = [
        'student_id',
        'category',
        'question',
        'image',
        'reply',
        'answer',
        'reply_by',
        'replied_at'
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getTimeAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('h:i A') : null;
    }   


    public function getDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('d/m/Y') : null;
    }

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getRepliedAtAttribute($value){
        return $value ? Carbon::parse($value)->format('d/m/Y h:i A') : null;
    }

    public function getFullImageAttribute(){
        if(empty($this->image))
            return '';

        return asset('storage/image/' . $this->image);
    }

    public function getReplyerAttribute(){
            $temp= User::find($this->reply_by);
           return $temp->name ?? '';
    }

}
