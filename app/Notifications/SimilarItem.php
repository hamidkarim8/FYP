<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SimilarItem extends Notification
{
    use Queueable;
    private $item;
    private $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($item, $report)
    {
        $this->item = $item;
        $this->report = $report;
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
        return [
            'item_type' => $this->item->type,
            'message' => 'This might be your item which reported ' . $this->item->type . ' . Check it out!',
            'item_id' => $this->item->id,
            'report_id' => $this->report->id,
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
