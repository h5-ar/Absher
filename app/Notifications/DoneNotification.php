<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoneNotification extends Notification
{
    use Queueable;

    private $company;
    private $message;
    private $super_admin;

    /**
     * Create a new notification instance.
     */
    public function __construct($company, $message, $super_admin)
    {
        $this->company = $company;
        $this->super_admin = $super_admin;
        $this->message = $message;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'company' => $this->company,
            'super_admin' => $this->super_admin,
            'message' => $this->message,
        ];
    }
}
