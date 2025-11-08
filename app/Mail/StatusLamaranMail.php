<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusLamaranMail extends Mailable
{
    use Queueable, SerializesModels;
    public $namaPelamar;
    public $judulLowongan;
    public $status;
    public $namaPerusahaan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($namaPelamar, $judulLowongan, $status, $namaPerusahaan)
    {
        $this->namaPelamar = $namaPelamar;
        $this->judulLowongan = $judulLowongan;
        $this->status = $status;
        $this->namaPerusahaan = $namaPerusahaan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->status === 'diterima'
            ? 'Selamat! Lamaran Anda Diterima'
            : 'Informasi Status Lamaran Anda';
        return $this->subject($subject)
                    ->markdown('emails.status_lamaran');
    }
}
