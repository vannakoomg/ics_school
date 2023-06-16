<?php

namespace App\Broadcasting;

use App\User;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{

    public function send($notifiable, Notification $notification)
    {
        /** @var \Kutia\Larafirebase\FirebaseMessage $message */
        $message = $notification->toFirebase($notifiable);
    }


}
