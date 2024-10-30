<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpcomingInvoice extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your upcoming invoice is due soon')
            ->view('emails.upcomingInvoice')
            ->with('invoice', $this->invoice);
    }
}
