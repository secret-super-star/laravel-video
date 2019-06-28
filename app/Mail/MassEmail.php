<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MassEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    
    public $subject;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $subject)
    {
        $this->content = $content;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.massEmails.emailTemplate',[
        	'content' => $this->content
        ])->from(\Config::get('mail.username'))->subject($this->subject);
    }
}
