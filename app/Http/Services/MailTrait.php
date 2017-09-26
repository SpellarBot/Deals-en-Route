<?php

namespace App\Http\Services;

use Mail;
use App\Mail\EmailVerify;
trait MailTrait {
    
    
  public function sendMail($array_mail){

   
         Mail::to($array_mail['to'])->send(new EmailVerify($array_mail['data']));
   
    
  }
  
  public function confirmCode(){
      
  }
    
}