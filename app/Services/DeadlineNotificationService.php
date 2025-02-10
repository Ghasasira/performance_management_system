<?php

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeadlineNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $details;

    public function __construct(string $type, $details)
    {
        $this->type = $type;
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->type === 'task') {
            return (new MailMessage)
                ->subject('Task Deadline Approaching')
                ->line('Your task "' . $this->details->title . '" is approaching its deadline.')
                ->line('Deadline: ' . $this->details->deadline)
                ->action('View Task', url('/tasks/' . $this->details->id));
        }

        if ($this->type === 'quarter') {
            return (new MailMessage)
                ->subject('Quarter Ending Soon')
                ->line('The current quarter "' . $this->details->name . '" is about to end.')
                ->line('End Date: ' . $this->details->end_date)
                ->action('View Quarter Details', url('/quarters/' . $this->details->id));
        }
    }
}
