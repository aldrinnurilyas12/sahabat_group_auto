<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailMarketing;
use Illuminate\Support\Facades\DB;

class EmailMarketingVehicle extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailMarketing $EmailMarketing)
    {
        $vehicle_data = DB::table('v_vehicle')->select(
            'unit',
            'brand',
            'vehicle_type',
            'manufacture_year',
            'vehicle_category',
            'color',
            'location_name',
            'images'
        )->leftJoin('vehicle_fotos', 'v_vehicle.id', '=', 'vehicle_fotos.vehicle_id')->where('v_vehicle.id', $EmailMarketing->vehicle_id)
            ->whereNotIn('category_name', ['Unit Terjual', 'Unit Dalam Perbaikan', 'Unit Booked'])
            ->first();

        $this->EmailMarketing = $EmailMarketing;

        $images = DB::table('vehicle_fotos')->where('vehicle_id', $EmailMarketing->vehicle_id)->get();
        $this->data = [
            'title'      => $EmailMarketing->title,
            'subject'   => $EmailMarketing->subject,
            'media_files'  => $EmailMarketing->media_files,
            'description' => $EmailMarketing->description,
            'link' => $EmailMarketing->link,
            'unit' => $vehicle_data->unit,
            'brand' => $vehicle_data->brand,
            'vehicle_type' => $vehicle_data->vehicle_type,
            'manufacture_year' => $vehicle_data->manufacture_year,
            'vehicle_category' => $vehicle_data->vehicle_category,
            'color' => $vehicle_data->color,
            'location_name' => $vehicle_data->location_name,
            'images' => $images
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
            view: 'layouts.mail.email_marketing_vehicle',
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
