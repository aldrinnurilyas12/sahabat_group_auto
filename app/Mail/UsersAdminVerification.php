<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UsersAdminVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $User_verif;

    public function __construct(User $User_verif)
    {

        $get_name = DB::table('v_users')->where('nik', $User_verif->nik)->first();
        $get_password = DB::table('users')->where('nik', $User_verif->nik)->first();
        $this->User_verif = $User_verif;


        $this->data = [
            'nik' => $User_verif->nik,
            'name' => $get_name->name,
            'password' => $get_password->password
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Email Pengguna',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail.users_verification',
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