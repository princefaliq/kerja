<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PerusahaanStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $perusahaan;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($perusahaan, $status)
    {
        $this->perusahaan = $perusahaan;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->status === 'aktif'
            ? 'Akun Perusahaan Anda Telah Diaktifkan'
            : 'Akun Perusahaan Anda Dinonaktifkan';

        return $this->subject($subject)
            ->view('emails.status_perusahaan');
    }
}
