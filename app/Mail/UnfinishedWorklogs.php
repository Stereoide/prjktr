<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnfinishedWorklogs extends Mailable
{
    use Queueable, SerializesModels;

    /* Properties */

    public $worklogs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($worklogs)
    {
        $this->worklogs = $worklogs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.unfinished-worklogs')
            ->text('emails.unfinished-worklogs-text');
    }
}
