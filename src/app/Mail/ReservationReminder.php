<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $signedUrl = URL::signedRoute('reservation.confirm',['reservation' => $this->reservation->id]);
        $qrCode = QrCode::size(200)->generate($signedUrl);
        return $this->subject('予約リマインダー')
            ->view('email.reminder')
            ->with([
                'qrCode' => $qrCode,
                'reservation' => $this->reservation
            ]);
    }
}
