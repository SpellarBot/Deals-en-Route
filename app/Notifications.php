<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Auth;

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
        $returnvalue['is_reedem'] = $data['is_reedem'];
        self::sendNotification($returnvalue);
        return $returnvalue;
    }

    public static function sendNotification($returnvalue) {

        $notificaitondata = $returnvalue->getAttributes();

//        print_r($notificaitondata);
//        die;
        $messagedata = json_decode($notificaitondata['data']);
        $tokens = DeviceDetail::where('user_id', $notificaitondata['notifiable_id'])->first();
        $data = array(
            "aps" => [
                "alert" => [
                    "title" => $messagedata->type,
                    "body" => ['message' => $messagedata->message,
                        'coupon_id' => $notificaitondata['coupon_id'],
                        "activity_id" => ((array_key_exists("activity_id", $notificaitondata) && $notificaitondata['activity_id']) ? $notificaitondata['activity_id'] : ""),
                        "is_reedem" => $notificaitondata['is_reedem']
                    ],
                    "badge" => 1
                ],
                "mutable-content" => "1",
                "category" => "newCategory"
            ],
            "otherCustomURL" => "http://i.przedszkola.edu.pl/d8/28/47-zimowe-zabawy-konspekt-zaj-hospitowanych.jpg"
        );
//        print_r($data);
//        die;
        if (!empty($tokens)) {
            $noti = self::sendAPNSNotificaiton($tokens->device_token, '', $data);
//            $noti = self::sendAPNSNotificaiton('', '', $data);
            return $noti;
        }

//        $optionBuiler = new OptionsBuilder();
//        $optionBuiler->setTimeToLive(60 * 20);
//        $notificationBuilder = new PayloadNotificationBuilder();
//
//        $notificationBuilder->setBody($returnvalue->data['message'])->setSound('default');
//
//        $dataBuilder = new PayloadDataBuilder();
//        $user = User::find($returnvalue->notifiable_id);
//        $unread = $user->unreadNotifications->count();
//
//        $finaldata = array_merge($returnvalue->data, ['badge' => $unread]);
//
//        $dataBuilder->addData($finaldata);
//        $option = $optionBuiler->build();
//        $notification = $notificationBuilder->build();
//        $data = $dataBuilder->build();
//
//// You must change it to get your tokens
//        $tokens = DeviceDetail::where('user_id', $returnvalue->notifiable_id)->first();
//
//        if (!empty($tokens)) {
//            $downstreamResponse = FCM::sendTo([$tokens->device_token], $option, $notification, $data);
//            return $downstreamResponse->numberSuccess();
//        }
    }

    public static function sendAPNSNotificaiton($token = '', $option = '', $data = '', $notification = '') {
        $apnsHost = 'gateway.sandbox.push.apple.com';
//        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $privateKeyPassword = '123456';
        if ($token) {
            $deviceToken = $token;
        } else {
            $deviceToken = '625af8cf971325f57c96a1e30637d6b830878671a7d93322a22add43a4205184';
        }
        $pushCertAndKeyPemFile = __DIR__ . '/apns-dev.pem';
        $stream = stream_context_create();
        stream_context_set_option($stream, 'ssl', 'local_cert', $pushCertAndKeyPemFile);
        stream_context_set_option($stream, 'ssl', 'passphrase', $privateKeyPassword);
        $connection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $stream);
        if (!$connection) {
            echo "Failed to connect to the APNS server. Error no = $errorNumber<br/>";
            exit;
        }
        $messageBody = $data;
        $payload = json_encode($messageBody);
        $notification = chr(0) .
                pack('n', 32) .
                pack('H*', $deviceToken) .
                pack('n', strlen($payload)) .
                $payload;
        $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));
//        if (!$wroteSuccessfully) {
//            echo "Could not send the message<br/>";
//        } else {
//            echo "Successfully sent the message<br/>";
//        }
        fclose($connection);
    }

}
