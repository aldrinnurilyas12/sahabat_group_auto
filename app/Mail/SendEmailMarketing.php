<?php

namespace App\Mail;

use App\Models\EmailMarketing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailMarketing extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailMarketing $EmailMarketing)
    {
        $this->EmailMarketing = $EmailMarketing;

        $this->data = [
            'title'      => $EmailMarketing->title,
            'subject'   => $EmailMarketing->subject,
            'media_files'  => $EmailMarketing->media_files,
            'description' => $EmailMarketing->description,
            'link' => $EmailMarketing->link
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.email_marketing'
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
