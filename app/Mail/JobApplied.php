<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
class JobApplied extends Mailable
{
    use Queueable, SerializesModels;

    // define properties
    public $application;
    public $job;

    /**
     * Create a new message instance.
     */
    public function __construct($application, $job)
    {
        $this->application = $application;
        $this->job = $job;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.job-applied',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if ($this->application->cv_path) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/' . $this->application->cv_path))
                ->as($this->application->cv_path)
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
