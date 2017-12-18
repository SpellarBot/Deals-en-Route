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
            return [
            'type' => $this->data['type'],
            'message' => $this->data['message'],
            'name' => empty($this->data['name'])?'':$this->data['name'],
            'image' =>empty($this->data['image'])?'':$this->data['image'],
            'notification_message' => $this->data['notification_message'],
            'coupon_id' => (empty($this->data['coupon_id'])?'':$this->data['coupon_id']),
            'activity_id' => (empty( $this->data['activity_id'])?'': $this->data['activity_id']),
        ]; 
         
    }

}
