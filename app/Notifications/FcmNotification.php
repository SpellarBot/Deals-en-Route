<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications;

class FcmNotification extends Notification {

    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return [Notifications::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable) {
        
        $DatabaseNotification = $notifiable->notifications->first();
         if(isset($this->data['name']) && isset( $this->data['name'])) {
            return [
            'type' => $this->data['type'],
            'message' => $this->data['message'],
            'name' => $this->data['name'],
            'image' => $this->data['image'],
            'notification_message' => $this->data['notification_message'],
            'coupon_id' => $this->data['coupon_id'],
            'notification_id' => (empty($DatabaseNotification))?'1':$DatabaseNotification->getKey(),
        ];  
         }else {

        return [
            'type' => $this->data['type'],
            'message' => $this->data['message'],
            'notification_message' => $this->data['notification_message'],
            'coupon_id' => $this->data['coupon_id'],
            'notification_id' => (empty($DatabaseNotification))?'1':$DatabaseNotification->getKey(),
        ];
         }
    }

}
