<?php

namespace App\Mail;

use App\Models\DailyEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntryUpdated extends Mailable
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
        return $this->subject('Daily Entry Updated')
                    ->view('emails.entry_updated')
                    ->with(['entry' => $this->entry]);
    }
}
?>
