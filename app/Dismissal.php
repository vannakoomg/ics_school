<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dismissal extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $appends = ['date','timein','timeout']; 
    public $table = 'dismissal';

    // protected $cats = ['opti8ons' => 'json'];
    protected $dates = [
        'created_at',
        'updated_at',
        'date_time',
    ];

    protected $fillable = [
        'student_id',
        'date_time',
        'status'
    ];


   public function getDateAttribute(){
       return $this->date_time->format("d-m-Y");
   }

   public function getTimeinAttribute(){
    return $this->date_time->format("h:i A");
    }

    public function getTimeoutAttribute(){
        return $this->updated_at ? $this->updated_at->format("h:i A") : '';
    }

   public function student(){

    return $this->belongsTo(User::class, 'student_id');
    
   }

   public function gettime(){
       return $this->date_time ? Carbon::parse($this->date_time)->format('h:i A') : null;
   }
//    public function class(){
//     return $this->belongsTo(SchoolClass::class, 'class_id');
// }   

}
