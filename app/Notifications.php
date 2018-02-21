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
        self::sendAPNSNotificaiton('', '', $data);
        die;

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder();

        $notificationBuilder->setBody($returnvalue->data['message'])->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $user = User::find($returnvalue->notifiable_id);
        $unread = $user->unreadNotifications->count();

        $finaldata = array_merge($returnvalue->data, ['badge' => $unread]);

        $dataBuilder->addData($finaldata);
        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

// You must change it to get your tokens
        $tokens = DeviceDetail::where('user_id', $returnvalue->notifiable_id)->first();

        if (!empty($tokens)) {
            $downstreamResponse = FCM::sendTo([$tokens->device_token], $option, $notification, $data);
            return $downstreamResponse->numberSuccess();
        }
    }

    public static function sendAPNSNotificaiton($token = '', $option = '', $data = '', $notification = '') {
//         /* We are using the sandbox version of the APNS for development. For production
//        environments, change this to ssl://gateway.push.apple.com:2195 */
//        $apnsServer = 'ssl://gateway.sandbox.push.apple.com:2195';
//        $apnsServer = 'ssl://gateway.push.apple.com:2195';
        $apnsHost = 'gateway.sandbox.push.apple.com';
//        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        /* Make sure this is set to the password that you set for your private key
          when you exported it to the .pem file using openssl on your OS X */
        $privateKeyPassword = '123456';
        /* Put your own message here if you want to */
        $message = 'Welcome to iOS 7 Push Notifications';
        /* Pur your device token here */
//        $deviceToken = '1f756b19a78b9a94fac86ede70eb97943db8209872ab0ae18eecd20bcfe20783';
        $deviceToken = '625af8cf971325f57c96a1e30637d6b830878671a7d93322a22add43a4205184';
        /* Replace this with the name of the file that you have placed by your PHP
          script file, containing your private key and certificate that you generated
          earlier */
        $pushCertAndKeyPemFile = __DIR__ . '/apns-dev.pem';
        $stream = stream_context_create();
        stream_context_set_option($stream, 'ssl', 'local_cert', $pushCertAndKeyPemFile);
        stream_context_set_option($stream, 'ssl', 'passphrase', $privateKeyPassword);
//        $connectionTimeout = 20;
//        $connectionType = STREAM_CLIENT_CONNECT;
//        $connection = stream_socket_client($apnsServer, $errorNumber, $errorString, $connectionTimeout, $connectionType, $stream);
        $connection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $stream);
        if (!$connection) {
            echo "Failed to connect to the APNS server. Error no = $errorNumber<br/>";
            exit;
        } else {
            echo "Successfully connected to the APNS. Processing...</br>";
        }
//        $messageBody['aps'] = array('alert' => $message,
//            'sound' => 'default',
//            'badge' => 2,
//        );
        $messageBody = $data;
        $payload = json_encode($messageBody);
        $notification = chr(0) .
                pack('n', 32) .
                pack('H*', $deviceToken) .
                pack('n', strlen($payload)) .
                $payload;
        $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));

        if (!$wroteSuccessfully) {
            echo "Could not send the message<br/>";
        } else {
            echo "Successfully sent the message<br/>";
        }
        fclose($connection);
        print_r($wroteSuccessfully);
    }

}
