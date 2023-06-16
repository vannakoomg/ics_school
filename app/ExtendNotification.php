<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;
// use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExtendNotification extends DatabaseNotification
{
   
    // protected $dates=['created_at'];
    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d h:i:s'
    // ];
    protected $appends = ['date','time'];

    public function getTimeAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('h:i A') : null;
    }   


    public function getDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('d/m/Y') : null;
    }

    public function getCreatedAtAttribute($date){
        
     
        return Carbon::createFromTimestamp(strtotime($date))
                ->timezone('Asia/Phnom_Penh')
                ->toDateTimeString();
    }  

    public function getUpdatedAtAttribute($date){
        return Carbon::createFromTimestamp(strtotime($date))
        ->timezone('Asia/Phnom_Penh')
        ->toDateTimeString();
    }  


}
