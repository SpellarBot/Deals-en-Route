<?php

namespace App\Http\Services;

use Mail;

trait MailTrait {
    
    
  public function sendMail($array_mail){
      
         Mail::send($array_mail['template'], $array_mail['data'], 
         function($message) use ($array_mail) {
         $message->to($array_mail['to'])->subject($array_mail['subject']);
         
      });
  }
  
  public function confirmCode(){
      
  }
    
}