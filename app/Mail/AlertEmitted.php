<?php

namespace App\Mail;

use App\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertEmitted extends Mailable
{
    use Queueable, SerializesModels;

    private $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->markdown('email.alert')
        ->with([
            'lat' => $this->alert->lat,
            'alert' => $this->alert,

            ]);
    }
}
