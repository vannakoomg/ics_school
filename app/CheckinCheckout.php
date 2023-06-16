<?php
namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class CheckinCheckout extends Authenticatable
{
    use Notifiable, HasApiTokens;
    // use \Illuminate\Notifications\Notifiable;

    protected $connection = 'sqlsrv';

    public $timestamps = false;
    
    protected $fillable = ['userid','checktime','checktype','verifycode','sensorid','Memoinfo','workcode','sn','userextfmt'];

    public $table = 'CHECKINOUT';
    
}