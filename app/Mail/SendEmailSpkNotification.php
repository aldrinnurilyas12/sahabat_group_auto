<?php

namespace App\Mail;

use App\Models\SpkUnitModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendEmailSpkNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data;


    /**
     * Create a new message instance.
     */
    public function __construct(SpkUnitModel $Spk)
    {
        $this->SpkUnitModel = $Spk;
        $v_spk = DB::table('v_spk')->select('unit')->where('vehicle_id', $Spk->vehicle_id)->first();
        $stackholder = DB::table('v_employee')->select('name')
            ->whereIn('job_id', ['9', '10'])->get();

        $employee_name = $stackholder->pluck('name')->toArray();

        $this->data = [
            'unit' => $v_spk->unit,
            'location_unit' => $Spk->location_unit,
            'name' => $Spk->name,
            'address' => $Spk->address,
            'spk_status' => $Spk->spk_status,
            'spk_confirmation_date' => $Spk->spk_confirmation_date,
            'created_at' => $Spk->created_at,
            // 'employee_name' => implode(', ', $stackholder->pluck('name')->toArray()),
        ];
    }

    // code untuk mengirim notifikasi ke dpeartment Finance, Sales Manager dan Branch:
    //  $stackholder = DB::table('v_employee')->select('name')->whereIn('job_id', ['1', '2', '4', '6', '9', '10'])->get();


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        $unit = $this->data['unit'] ?? 'Uknown';
        $dateFormatted = isset($this->data['spk_confirmation_date'])
            ? Carbon::parse($this->data['spk_confirmation_date'])->format('d-m-Y')
            : now()->format('d-m-Y');


        return new Envelope(
            subject: 'SPK Unit' . ' '  . $unit . ' ' . 'Realese' . ' ' . $dateFormatted
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.spk_notification',
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
