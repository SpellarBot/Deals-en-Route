<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class Notifications extends Model {

    use Notifiable;

    public function send($notifiable, Notification $notification) {
        $data = $notification->toDatabase($notifiable);
        $notificationmessage = $data['notification_message'];
        unset($data['notification_message']);
        $returnvalue = $notifiable->routeNotificationFor('database')->create([
            'message' => $notificationmessage,
            'from_id' => (empty(\Auth::user())) ? '' : \Auth::user()->id,
            'type' => $data['type'],
            'data' => $data,
            'read_at' => null,
            'is_read' => 0,
            'coupon_id' => $data['coupon_id']
        ]);
        self::sendNotification($returnvalue);
        return $returnvalue;
    }

    public static function sendNotification($returnvalue) {

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setBody($returnvalue->message)->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder->addData($returnvalue->data);

        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

// You must change it to get your tokens
        $tokens = DeviceDetail::where('user_id', $returnvalue->notifiable_id)->first();
        if (!empty($tokens)) {
            $downstreamResponse = FCM::sendTo([$tokens->device_token], $option, $notification, $data);
        }
    }

}
