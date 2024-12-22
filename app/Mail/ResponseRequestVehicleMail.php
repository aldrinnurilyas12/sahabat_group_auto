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

class ResponseRequestVehicleMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(VehicleCustomerRequest $vehiclerequest)
    {
        $vehicle_data = DB::table('customer_vehicle_request as vr')
            ->select('vr.name', 'vr.vehicle_type', 'vehicle_brand.brand_name', 'vr.year', 'vr.vehicle_color', 'vr.description')
            ->leftJoin('vehicle_brand', 'vr.brand', '=', 'vehicle_brand.id')->where('vr.id', $vehiclerequest->id)->first();

        $this->vehiclerequest = $vehiclerequest;

        $this->data = [
            'name'      => $vehiclerequest->name,
            'vehicle_type' => $vehiclerequest->vehicle_type,
            'year'  => $vehiclerequest->year,
            'vehicle_color' => $vehiclerequest->vehicle_color,
            'brand_name' => $vehicle_data->brand_name,
            'description' => $vehicle_data->description
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Pencarian Unit Kendaraan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.customers_request_information'
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
