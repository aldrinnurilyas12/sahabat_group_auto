<?php

namespace App\Mail;

use App\Models\VehicleCarSaleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ResponseRequestVehicleSaleMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(VehicleCarSaleRequest $vehiclerequest)
    {
        $customer_request_sale_data = DB::table('vehicle_sale_request as vsr')
            ->select('vsr.id', 'vehicle_type', 'vb.brand_name as brand_name', 'vehicle_year', 'current_km', 'vehicle_color', 'name', 'email', 'phone_number', 'status', 'sending_email', 'description', 'vsr.created_at')
            ->leftJoin('vehicle_brand as vb', 'vsr.brand_id', '=', 'vb.id')->where('vsr.id', $vehiclerequest->id)->first();

        $this->vehiclerequest = $vehiclerequest;

        $this->data = [
            'name'      => $vehiclerequest->name,
            'vehicle_type' => $vehiclerequest->vehicle_type,
            'vehicle_year'  => $vehiclerequest->vehicle_year,
            'vehicle_color' => $vehiclerequest->vehicle_color,
            'brand_name' => $customer_request_sale_data->brand_name,
            'status' => $customer_request_sale_data->status,
            'description' => $customer_request_sale_data->description
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Jual Unit Kendaraan customer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.customers_request_information_sale'
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
