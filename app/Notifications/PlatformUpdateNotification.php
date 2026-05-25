<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlatformUpdateNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly ?string $actionUrl = null,
        private readonly string $actionText = 'Buka CareerBridge',
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject($this->title)
            ->greeting('Halo '.$notifiable->name.',')
            ->line($this->body);

        if ($this->actionUrl) {
            $message->action($this->actionText, $this->actionUrl);
        }

        return $message
            ->line('Terima kasih sudah menggunakan CareerBridge.');
    }
}
