<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnassignedProjects extends Mailable
{
    use Queueable, SerializesModels;

    /* Properties */

    public $projects;
    public $subprojects;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projects, $subprojects)
    {
        $this->projects = $projects;
        $this->subprojects = $subprojects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.unassigned-projects')
            ->text('emails.unassigned-projects-text');
    }
}
