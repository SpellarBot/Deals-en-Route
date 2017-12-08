<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentSuccess extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $invoice) {
        $this->data = $data;
        if ($invoice && !empty($invoice)) {
            $this->invoice = $invoice;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        if ($this->invoice && !empty($this->invoice)) {
            return $this->markdown('emails.paymentsuccess')
                            ->subject('Payment Successful')
                            ->with($this->data)
                            ->attach($this->invoice);
        } else {
            return $this->markdown('emails.paymentsuccess')
                            ->subject('Payment Successful')
                            ->with($this->data);
        }
    }

}
