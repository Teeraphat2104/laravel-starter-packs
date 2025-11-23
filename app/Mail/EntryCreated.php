<?php

namespace App\Mail;

use App\Models\DailyEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntryCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $entry;

    /**
     * Create a new message instance.
     */
    public function __construct(DailyEntry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Daily Entry Created')
                    ->view('emails.entry_created')
                    ->with(['entry' => $this->entry]);
    }
}
?>
