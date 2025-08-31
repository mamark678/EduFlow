<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminGeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyMessage;
    public $course;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectLine, $bodyMessage, $course = null)
    {
        $this->subjectLine = $subjectLine;
        $this->bodyMessage = $bodyMessage;
        $this->course = $course;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.admin-general')
                    ->with([
                        'bodyMessage' => $this->bodyMessage,
                        'course' => $this->course,
                    ]);
    }
} 