<?php

namespace App\Mail;

use App\Models\AppointmentModel;
use App\Models\VehicleCarSaleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendNotificationSaleRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public $request_data;

    /**
     * Create a new message instance.
     */
    public function __construct(VehicleCarSaleRequest $vehicle_request)
    {
        $vehicle_sale_request = DB::table('vehicle_sale_request')
            ->select('vehicle_type', 'vb.brand_name', 'vehicle_year', 'current_km', 'vehicle_color', 'unique_tokens')
            ->leftJoin('vehicle_brand as vb', 'vehicle_sale_request.brand_id', '=', 'vb.id')
            ->where('vehicle_sale_request.id', $vehicle_request->id)->first();

        // Check if the appointment_ads exists before trying to access properties
        if (!$vehicle_sale_request) {
            // Handle the case where no data is found, maybe set a default or throw an exception
            throw new \Exception("No Vehicle Request found for this email.");
        }

        $this->vehicle_request = $vehicle_request;
        $this->data = [
            'vehicle_type' => $vehicle_request->vehicle_type,
            'brand_name' => $vehicle_sale_request->brand_name,
            'vehicle_year' => $vehicle_sale_request->vehicle_year,
            'current_km' => $vehicle_sale_request->current_km,
            'vehicle_color' => $vehicle_sale_request->vehicle_color,
            'name'  => $vehicle_request->name,
            'unique_tokens' => $vehicle_request->unique_tokens
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Jual Unit Kendaraan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.salenotificationrequest',
        );
    }

    public function build()
    {
        return $this->subject('Success Appointment Schedule')

            ->view('layouts.mail.salenotificationrequest') // Ganti dengan path yang benar

            ->with([

                'name' => $this->vehicle_request->name

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
