<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Message')
            ->greeting('Hello Admin,')
            ->line('You have received a new contact message.')
            ->line('Name: ' . $this->data['name'])
            ->line('Email: ' . $this->data['email'])
            ->line('Subject: ' . $this->data['subject'])
            ->line('Message:')
            ->line($this->data['comments'])
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you!');
    }
}
