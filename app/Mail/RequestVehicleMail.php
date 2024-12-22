<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\VehicleCustomerRequest;
use Illuminate\Support\Facades\DB;

class RequestVehicleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $vehiclerequest;

    /**
     * Create a new message instance.
     */
    public function __construct(VehicleCustomerRequest $vehiclerequest)
    {
        $vehicle_data = DB::table('customer_vehicle_request as vr')
            ->select('vr.name', 'vr.vehicle_type', 'vehicle_brand.brand_name', 'vr.year', 'vr.vehicle_color', 'vr.unique_tokens')
            ->leftJoin('vehicle_brand', 'vr.brand', '=', 'vehicle_brand.id')->where('vr.id', $vehiclerequest->id)->first();

        $this->vehiclerequest = $vehiclerequest;

        $this->data = [
            'name'      => $vehiclerequest->name,
            'vehicle_type' => $vehiclerequest->vehicle_type,
            'year'  => $vehiclerequest->year,
            'vehicle_color' => $vehiclerequest->vehicle_color,
            'brand_name' => $vehicle_data->brand_name,
            'unique_tokens' => $vehicle_data->unique_tokens
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Pencarian unit kendaraan PT Sahabat Group Auto',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.customer_vehicle_request',
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
