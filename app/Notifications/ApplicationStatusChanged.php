<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Internship Application Status Changed')
            ->line("Your application status is now: {$this->status}")
            ->action('View Application', url('/dashboard'))
            ->line('Thank you for applying!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your internship application status has changed to '{$this->status}'"
        ];
    }
}
