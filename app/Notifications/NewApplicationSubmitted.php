<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewApplicationSubmitted extends Notification
{
    use Queueable;

    public function __construct(public $applicantName) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Internship Application Submitted')
            ->line("A new application has been submitted by {$this->applicantName}.")
            ->action('View Applications', url('/admin/applications'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New application submitted by {$this->applicantName}"
        ];
    }
}
