<?php

namespace App\Http\Services;

use Mail;
use App\Mail\EmailVerify;
use App\Mail\SendPasswordMail;
use App\Mail\EmailVerifyVendor;
use App\Mail\ContactUs;
use App\Mail\ContactUsWeb;
use App\Mail\PaymentSuccess;
use App\Mail\EmailPaymentFailed;
use App\Mail\PaymentCancel;
use App\Mail\SubscriptionCancelSuccees;
use App\Mail\SubscriptionCancelFailed;
use App\Mail\SubscriptionUpgradeFailed;
use App\Mail\SubscriptionUpgradeSuccess;
use App\Mail\SubscriptionDowngradeFailed;
use App\Mail\SubscriptionDowngradeSuccess;
use App\Mail\AdditionFeaturePurchaseSuccess;
use App\Mail\AdditionFeaturePurchaseFailed;

trait MailTrait {

    public function sendMail($array_mail) {

        if ($array_mail['type'] == 'verify') {
            Mail::to($array_mail['to'])->send(new EmailVerify($array_mail['data']));
        } else if ($array_mail['type'] == 'password') {
            Mail::to($array_mail['to'])->send(new SendPasswordMail($array_mail['data']));
        } else if ($array_mail['type'] == 'verifyvendor') {
            Mail::to($array_mail['to'])->send(new EmailVerifyVendor($array_mail['data']));
        } else if ($array_mail['type'] == 'paymentfailed') {
            Mail::to($array_mail['to'])->send(new EmailPaymentFailed($array_mail['data']));
        } else if ($array_mail['type'] == 'contactuser') {
            Mail::to($array_mail['to'])->send(new ContactUs($array_mail['data']));
        } else if ($array_mail['type'] == 'contactuserweb') {
            Mail::to($array_mail['to'])->send(new ContactUsWeb($array_mail['data']));
        } else if ($array_mail['type'] == 'payment_success') {
            Mail::to($array_mail['to'])->send(new PaymentSuccess($array_mail['data'], $array_mail['invoice']));
        } else if ($array_mail['type'] == 'payment_cancel') {
            Mail::to($array_mail['to'])->send(new PaymentCancel($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_cancel_success') {
            Mail::to($array_mail['to'])->send(new SubscriptionCancelSuccees($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_cancel_failed') {
            Mail::to($array_mail['to'])->send(new SubscriptionCancelFailed($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_upgrade_failed') {
            Mail::to($array_mail['to'])->send(new SubscriptionUpgradeFailed($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_upgrade_success') {
            Mail::to($array_mail['to'])->send(new SubscriptionUpgradeSuccess($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_downgrade_failed') {
            Mail::to($array_mail['to'])->send(new SubscriptionDowngradeFailed($array_mail['data']));
        } else if ($array_mail['type'] == 'subscription_downgrade_success') {
            Mail::to($array_mail['to'])->send(new SubscriptionDowngradeSuccess($array_mail['data']));
        } else if ($array_mail['type'] == 'additional_feature_purchase_success') {
            Mail::to($array_mail['to'])->send(new AdditionFeaturePurchaseSuccess($array_mail['data']));
        } else if ($array_mail['type'] == 'additional_feature_purchase_failed') {
            Mail::to($array_mail['to'])->send(new AdditionFeaturePurchaseFailed($array_mail['data']));
        }
    }

   

}
