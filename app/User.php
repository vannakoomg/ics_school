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
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    // use \Illuminate\Notifications\Notifiable;

    public $pushNotificationType = 'users';


    public $table = 'users';

    protected $appends =['fullimage','guardian1_photo','guardian2_photo','guardian3_photo'];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $dates = [
        'updated_at',
        'created_at',
        //'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'name',
        'namekh',
        'photo',
        'voice',
        'email',
        'password',
        'phone',
        'rfidcard',
        'guardian1',
        'guardian2',
        'guardian3',
        'class_id',
        'created_at',
        'updated_at',
        //'deleted_at',
        'email_verified_at',
    ];

    // public function notifications(){

    //     return $this->morphToMany(Resource::class, 'notifiable', 'notifications');

    // }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsTeacherAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsStudentAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }

    public function getIsDlpSupportAttribute(){
        return $this->roles()->where('title','dlp-support')->exists();
    }

    public function getIsDlpMonitoringAttribute(){
        return $this->roles()->where('title','dlp-monitoring')->exists();
    }

    public function getIsDlpAdminAttribute(){
        return $this->roles()->where('title','dlp-admin')->exists();
    }

    public function teacherLessons()
    {
        return $this->hasMany(Lesson::class, 'teacher_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }

    function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    function calling()
    {
        return $this->hasMany(Dismissal::class, 'student_id')->orderBy('updated_at','desc');
    }

    function result()
    {
        return $this->hasMany(HomeworkResult::class, 'student_id');
    }


    // function homework()
    // {
    //     return $this->hasMany(Homework::class, 'student_id');
    // }


    function classteacher(){
        return $this->belongsToMany(SchoolClass::class, 'teacher_class', 'teacher_id','class_id');
    }

    function courseteacher(){
        return $this->belongsToMany(Course::class, 'teacher_course', 'teacher_id','course_id');
    }

// if use Interest

//     public function routeNotificationFor($channel)
//     {
//
//     if($channel === 'PusherPushNotifications'){
//         return config('services.pusher')['interest'];
//     }
//
//     $class = str_replace('\\', '.', get_class($this));
//
//     return $class.'.'.$this->getKey();
//     }

    public function getFullImageAttribute(){
        $photo='';
        if(empty($this->photo) || !Storage::exists('/photo/' . $this->photo)) {
            if($this->roles->contains(3))
                $photo= 'image/teacher-avatar.png';
            else if($this->roles->contains(4))
                $photo = 'image/student-avatar.png';
            else   
                $photo = 'image/teacher-avatar.png';
        }else {
            $photo = 'photo/' . $this->photo;
        }  
                //Storage::exists(storage_path('photo/' . $this->photo))?
        return asset('storage/' . $photo);
        //Storage::exists('/photo/' . $this->photo)?asset('storage/photo/' . $this->photo): asset('storage/image/' . (($this->roles->contains(4))?'student-avatar.png':'teacher-avatar.png'));
    }

    public function getGuardian1PhotoAttribute(){
       return  asset('storage/photo/' . "{$this->id}_guardian1.png" ?? '');
    }

    public function getGuardian2PhotoAttribute(){
        return  asset('storage/photo/' . "{$this->id}_guardian2.png" ?? '');
     }

     public function getGuardian3PhotoAttribute(){
        return  asset('storage/photo/' . "{$this->id}_guardian3.png" ?? '');
     }

    public function dlpMonitorings()
    {
        return User::whereHas('roles', function($role) {
            $role->where('title','dlp-monitoring')->orWhere('title','dlp-admin');
        })->pluck('name')->toArray();
    }

     public function dlpSupports()
    {
        return User::whereHas('roles', function($role) {
            $role->where('title','dlp-support')->orWhere('title','dlp-admin');
        })->pluck('name')->toArray();
    }

    

    public function routeNotificationForPusherPushNotifications()
    {
        $users = [];

        if($this->getIsDlpMonitoringAttribute())
            $users = $this->dlpSupports();
        else
            $users = $this->dlpMonitorings();


        return $users;
    }

    public function getAttendanceDetail($date){

    $check_in = Attendance::whereDate('date',date_format(date_create($date),"Y-m-d"))->where('student_id',$this->id)->orderBy('id','asc')->where('status','Present')->first();
    $check_out = Attendance::whereDate('date',date_format(date_create($date),"Y-m-d"))->where('student_id',$this->id)->orderBy('id','desc')->where('status','Present')->first();

    if(empty($check_in))
	    return ['date'=>$date,'check_in'=>'','check_out'=>''];
    return ['date' => $check_in->date->format('d/m/Y'),'check_in'=> $check_in->date->format('h:i A'), 'check_out' =>(($check_in!=$check_out) ?  $check_out->date->format('h:i A'):'')];
    }
    
    public function getAttendance($date){
        $att = Attendance::where('student_id',$this->id)->whereDate('date', date_format(date_create($date),'Y-m-d'))->first();
        if($att)
            return $att->status;
        else
            return '';
    }

    public function getRemark($date){
        $att = Attendance::where('student_id',$this->id)->whereDate('date', date_format(date_create($date),'Y-m-d'))->first();
        if($att)
            return $att->remark;
        else
            return '';
    }

    public function firebasetokens(){
        return $this->belongsToMany(Firebasetoken::class)->withTimestamps();
    }


    public function notifications(){
        return $this->morphMany(ExtendNotification::class,'notifiable')->orderBy('created_at','desc');
    }

}
