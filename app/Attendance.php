<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $table='attendances';

    protected $appends = ['date_format','time_format'];

    protected $dates = [
      'created_at',
      'updated_at',
      'date'
  ];

      protected $fillable = [
      'user_id',
      'date',
      'student_id',
      'status',
      'remark'
      ];

  public function classes(){
      return $this->belongsTo(SchoolClass::class, 'class_id');
  }

  public function students(){
    return $this->belongsTo(User::class, 'student_id');
  }

  public function getTimeFormatAttribute(){
    return $this->date ? Carbon::parse($this->date)->format('h:i A') : null;
  }   


  public function getDateFormatAttribute(){
      return $this->date ? Carbon::parse($this->date)->format('d/m/Y') : null;
  }


}
