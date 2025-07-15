<?php

namespace App\Mail;

use App\Models\UnderDevelopmentSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class MaintenanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;


    public function __construct(UnderDevelopmentSetting $Maintenance)
    {
        $this->Maintenance = $Maintenance;

        $this->data = [
            'description' => $Maintenance->description,
            'start_date_maintenance' => $Maintenance->start_date_maintenance,
            'time_start_date_maintenance' => $Maintenance->time_start_date_maintenance,
            'end_date_maintenance' => $Maintenance->end_date_maintenance,
            'time_end_date_maintenance' => $Maintenance->time_end_date_maintenance

        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Maintenance Sistem',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.maintenance_notification'
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
