<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phone, $email, $message)
    {
        $this->name= $name;
        $this->phone= $phone;
        $this->email= $email;
        $this->message= $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.emails.demoMail', ['name' => $this->name, 'phone' => $this->phone,
        'email' => $this->email, 'messages' => $this->message]);
    }
}
