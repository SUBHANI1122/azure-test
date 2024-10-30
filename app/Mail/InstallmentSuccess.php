<?php

namespace App\Mail;

use App\Models\Installment;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstallmentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $installment;

    public function __construct(Ticket $ticket, Installment $installment)
    {
        $this->ticket = $ticket;
        $this->installment = $installment;
    }

    public function build()
    {
        return $this->view('mail.installment_success')
                    ->subject('Installment Payment Successful');
    }
}
