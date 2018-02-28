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

        self::sendNotification($returnvalue);
        return $returnvalue;
    }

    public static function sendNotification($returnvalue) {

        $notificaitondata = $returnvalue->getAttributes();

//        print_r($notificaitondata);
//        die;
        $messagedata = json_decode($notificaitondata['data']);
        $user = User::find($returnvalue->notifiable_id);
        $unread = $user->unreadNotifications->count();
        $tokens = DeviceDetail::where('user_id', $notificaitondata['notifiable_id'])->first();
        $data = [
            "aps" => [
                "alert" => [
                    "title" => "DealsEnRoute",
                    "body" => $messagedata->message,
                    "badge" => $unread
                ],
                 "data"=>$messagedata,
                "mutable-content" => "1",
             
            ],
            "attachment-url" => $messagedata->image
        ];
//       print_r($data);
//        die;
       
        if (!empty($tokens)) {
             //$tokenexplode=explode(':',$tokens->device_token);
     
               self::sendAPNSNotificaiton($tokens->device_token, '', $data);
             
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
       $apnsHost = \Config::get('constants.APNS_HOST');
     
//        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $privateKeyPassword =  \Config::get('constants.APNS_PASSWORD');
       
        $deviceToken = $token;
        
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
        $devicetokenapns=pack('H*', $deviceToken);
        $notification = chr(0) .pack('n', 32) . $devicetokenapns.pack('n', strlen($payload)) .$payload;
        $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));
        
//        if (!$wroteSuccessfully) {
//            echo "Could not send the message<br/>";
//        } else {
//            echo "Successfully sent the message<br/>";
//        }
        fclose($connection);
        }
    

}
