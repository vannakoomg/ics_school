<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dlp extends Model
{
//     use HasFactory;

    public $table = 'dlp';

    const UPDATED_AT = null;
//     const CREATED_AT = null;

//     public $timestamps = false;

    protected $dates = [
        'new_at',
        'received_at',
        'closed_at',
        'created_at'
    ];



    protected $fillable = [
        'class_id',
        'problem_type',
        'problem',
        'solution',
        'image',
        'status',
        'new_at',
        'new_by',
        'received_at',
        'received_by',
        'closed_at',
        'closed_by',
        'created_at'
    ];

    public function mydate()
    {
//         return 0;
       return $this->created_at->format('d/m/Y') . "<br/><span class='small'>" .  $this->created_at->format('h:i A') . "</span>";
    }

    public function getNew_AtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function newby()
    {
        return $this->belongsTo(User::class, 'new_by');
    }

    public function receivedby()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

     public function closedby()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    
}
