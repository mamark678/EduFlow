<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Course;
use App\Models\User;

class EnrollmentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
    public $student;
    public $enrollmentId;

    /**
     * Create a new message instance.
     */
    public function __construct(Course $course, User $student, $enrollmentId)
    {
        $this->course = $course;
        $this->student = $student;
        $this->enrollmentId = $enrollmentId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Enrollment Request - ' . $this->course->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.enrollment-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 