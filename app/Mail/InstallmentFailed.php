<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstallmentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $installment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, $installment)
    {
        $this->ticket = $ticket;
        $this->installment = $installment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Installment Payment Has Failed')
            ->view('mail.installment_failed')
            ->with([
                'ticketId' => $this->ticket->id,
                'installmentAmount' => $this->installment->amount,
                'dueDate' => $this->installment->due_date,
                'name' => $this->ticket->first_name . ' ' . $this->ticket->last_name,
            ]);
    }
}
