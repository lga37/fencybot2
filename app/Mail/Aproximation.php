<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Aproximation extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $tot;

    public function __construct($name,$tot)
    {
        $this->name = $name;
        $this->tot = $tot;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.aproximation')
        ->with([
            'name' => $this->name,
            'tot' => $this->tot,

            ]);
    }
}
