<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuspiciousWorklogs extends Mailable
{
    use Queueable, SerializesModels;

    /* Properties */

    public $suspiciousWorklogs;
    public $blockingWorklogs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($suspiciousWorklogs, $blockingWorklogs)
    {
        $this->suspiciousWorklogs = $suspiciousWorklogs;
        $this->blockingWorklogs = $blockingWorklogs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.suspicious-worklogs')
            ->text('emails.suspicious-worklogs-text');
    }
}
