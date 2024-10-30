<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiptNotification extends Notification
{
    use Queueable;
    public $url;
    public $ticket;
    public $subject;
    public $file;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket,$url, $subject='New Payment Received',$file='receipt')
    {
        $this->url = $url;
        $this->ticket = $ticket;
        $this->subject = $subject;
        $this->file = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject($this->subject)
        ->view('mail.club.'.$this->file,['url'=>$this->url,'ticket'=>$this->ticket]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
