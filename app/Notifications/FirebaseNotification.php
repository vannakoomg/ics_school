<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\Api\V1\Admin\UsersApiController;
//use App\Broadcasting\FirebaseChannel;
use Auth;
use App\User;

class FirebaseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    

    public function __construct($title,$message,$fcmTokens,$appname='',$trid=0,$image='',$default='title')
    {
        $this->title = $title;
        $this->message = $message;
        $this->fcmTokens = $fcmTokens;
        $this->trid = $trid;
        $this->appname = $appname;
        $this->image = $image;
        $this->default = $default;
        
       
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFirebase($notifiable)
    {   
        $userapicontroller = new UsersApiController;
        
        return ($userapicontroller->FirebaseMessage($this->appname,($this->default=='title')?$this->title:$this->message,$this->fcmTokens,['id'=> (in_array(strtolower($this->appname),['assignment','ics news','card scanner notification','ics feedback','order notification','top-up notification'])) ? $this->trid:$this->id ,'route'=>$this->appname,'class_id' => $notifiable->class_id,'user_id'=>$notifiable->id]));   //withPriority('high')->
    }

    // public function toDatabase($notifiable)
    // {
   
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    //  public function notify($user){
        
    //         $duplicate = $user->notifications()->where([
    //             'type' => get_class($this->notification),
    //             'notifiable_type' => get_class($user),
    //             'notifiable_id' => $user->id,
    //             'data' => json_encode($this->notification->toArray($user))
    //         ])->first();
    //         if ($duplicate) return;
        
    //     $user->notify($this->notification);
    // }


 
    public function toArray($notifiable)
    {

        // dd($notifiable);

        // $duplicate = $this->user->notifications()->where([
        //     'type' => get_class($this->notification),
        //     'notifiable_type' => get_class($this->user),
        //     'notifiable_id' => $this->user->id,
        //     'data' => json_encode($this->notification->toArray($this->user))
        // ])->first();
        
        // if ($duplicate) return;

        //dd('trid' => (in_array(strtolower($this->appname),['assignment','ics news','card scanner notification','ics feedback'])) ? $this->trid:$this->id));    
        if(!empty($this->appname))
        return [
            'title' => (strtolower($this->appname)=='card scanner notification') ? $this->message : $this->title,
            'message' =>  (strtolower($this->appname)=='card scanner notification') ? $this->title : $this->message,
            'fcmTokens' => $this->fcmTokens,
            'appname'=> $this->appname,
            'trid' => (in_array(strtolower($this->appname),['assignment','ics news','card scanner notification','ics feedback','drder notification','top-up notification'])) ? $this->trid:$this->id,
            'image' => $this->image,
            'fullimage' => empty($this->image) ? '' : asset('storage/image/' . $this->image),
            'class_id' => $notifiable->class_id,
           
        ];
    }
}
