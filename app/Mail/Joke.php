<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Joke extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Joke to be sent.
     *
     * @var String
     */
    public $joke;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($joke)
    {
        $this->joke = $joke;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.joke');
    }
}
