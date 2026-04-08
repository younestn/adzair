<?php

namespace App\Notifications;

use App\Models\AdPageAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly AdPageAssignment $assignment)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('New Ad Assignment')
            ->line('A new ad has been assigned to one of your verified social pages.')
            ->line('Assignment ID: ' . $this->assignment->id);
    }
}
