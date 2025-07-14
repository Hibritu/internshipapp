<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Interview;

class InterviewScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $interview;

    /**
     * Create a new notification instance.
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    /**
     * Get the notification's delivery channels.
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
    return (new MailMessage)
        ->subject('Interview Scheduled')
        ->greeting('Hello ' . $notifiable->name . ',')
        ->line('Your internship application has been accepted!')
        ->line('📅 Interview Time: ' . $this->interview->interview_time)
        ->line('📍 Interview Link: ' . ($this->interview->interview_link ?? 'Not provided'))
        ->line('📝 Notes: ' . ($this->interview->notes ?? 'No notes provided'))
        ->line('Please join on time. Good luck!')
        ->salutation('— Internship System');
}

}
