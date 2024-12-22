<?php

namespace App\Mail;

use App\Models\AppointmentModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendEmailAppointment extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(AppointmentModel $appointment)
    {
        $appointment_ads = DB::table('v_appointment')->where('id', $appointment->id)->first();

        // Check if the appointment_ads exists before trying to access properties
        if (!$appointment_ads) {
            // Handle the case where no data is found, maybe set a default or throw an exception
            throw new \Exception("No appointment ads found for this email.");
        }

        $this->appointment = $appointment;
        $this->data = [
            'name' => $appointment->name,
            'date' => $appointment->date,
            'schedule_time' => $appointment_ads->schedule_time,
            'location_unit' => $appointment_ads->location_unit,
            'unit' => $appointment_ads->unit,
            'address' => $appointment_ads->address,
            'no_telepon' => $appointment_ads->no_telepon
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Appointment Test Drive/Kunjungan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.appointment_mail',
        );
    }

    public function build()
    {
        return $this->subject('Success Appointment Schedule')

            ->view('layouts.mail.appointment_mail') // Ganti dengan path yang benar

            ->with([

                'name' => $this->appointment->name,

                'date' => $this->appointment->date,

                'schedule_time' => $this->appointment->schedule_time,

            ]);
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
