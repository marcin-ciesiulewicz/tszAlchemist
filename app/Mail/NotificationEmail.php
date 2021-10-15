<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $type, array $data, string $subject = 'Notification Email')
    {
        $this->data = $data;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification-mail');
    }
}
