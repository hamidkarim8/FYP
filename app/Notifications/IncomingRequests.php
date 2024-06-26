<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncomingRequests extends Notification
{
    use Queueable;

    private $requests;
    // private $reports;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requests)
    {
        $this->requests = $requests;
        // $this->reports = $reports;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $requestType = $this->requests->type;

        switch ($requestType) {
            case 'contact':
                $requestTypeText = 'Contact Information';
                break;
            case 'proof_of_ownership':
                $requestTypeText = 'Proof of Ownership';
                break;
            default:
                $requestTypeText = ucfirst($requestType);
                break;
        }

        return [
            'report_id' => $this->requests->detailed_report_id,
            'request_id' => $this->requests->id,
            'message' => "Someone has submitted a request for " . $requestTypeText . ". Click to check it out now!",
        ];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
