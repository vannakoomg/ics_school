<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    use HasFactory;

    protected $table='message';

    protected $appends = ['full_image','date','time'];

      protected $dates = [
        'created_at',
        'updated_at',
    ];

        protected $fillable = [
        'user_id',
        'title',
        'body',
        'thumbnail',
        'send',
        ];

    public function getTimeAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('h:i A') : null;
    }   


    public function getDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('d/m/Y') : null;
    }

    public function classes(){
        return $this->belongsToMany(SchoolClass::class, 'message_class');
    }

    public function getPostedByAttribute(){
        return User::find($this->user_id)->name;
    }

    public function getFullImageAttribute(){
        return asset('storage/image/' . $this->thumbnail);
    }


    public function getUpdatedAtAttribute($value){
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}
